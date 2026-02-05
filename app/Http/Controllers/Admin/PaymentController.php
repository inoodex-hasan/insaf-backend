<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view-payments')->only(['index']);
        $this->middleware('can:create-payment')->only(['create', 'store']);
        $this->middleware('can:update-payment')->only(['edit', 'update']);
        $this->middleware('can:delete-payment')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $this->authorize('view-payments');

        $query = Payment::with(['student', 'collector']);

        if ($search = $request->get('search')) {
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($type = $request->get('payment_type')) {
            $query->where('payment_type', $type);
        }

        if ($status = $request->get('payment_status')) {
            $query->where('payment_status', $status);
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $this->authorize('create-payment');

        $students = Student::orderBy('first_name')->get(['id', 'first_name', 'last_name', 'phone']);
        $users = User::orderBy('name')->get(['id', 'name']);

        return view('admin.payments.create', compact('students', 'users'));
    }

    public function store(Request $request)
    {
        $this->authorize('create-payment');

        $validated = $this->validatePayment($request);

        if (empty($validated['collected_by'])) {
            $validated['collected_by'] = Auth::id();
        }

        Payment::create($validated);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    public function edit(Payment $payment)
    {
        $this->authorize('update-payment');

        $students = Student::orderBy('first_name')->get(['id', 'first_name', 'last_name', 'phone']);
        $users = User::orderBy('name')->get(['id', 'name']);

        return view('admin.payments.edit', compact('payment', 'students', 'users'));
    }

    public function update(Request $request, Payment $payment)
    {
        $this->authorize('update-payment');

        $validated = $this->validatePayment($request);

        if (empty($validated['collected_by'])) {
            $validated['collected_by'] = $payment->collected_by;
        }

        $payment->update($validated);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $this->authorize('delete-payment');

        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    private function validatePayment(Request $request): array
    {
        return $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_type' => ['required', Rule::in(['advance', 'final'])],
            'payment_date' => ['required', 'date'],
            'collected_by' => ['nullable', 'exists:users,id'],
            'receipt_number' => ['nullable', 'string', 'max:50'],
            'payment_status' => ['required', Rule::in(['pending', 'completed'])],
        ]);
    }
}
