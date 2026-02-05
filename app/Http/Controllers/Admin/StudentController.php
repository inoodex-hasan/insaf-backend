<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view-students')->only(['index']);
        $this->middleware('can:create-student')->only(['create', 'store']);
        $this->middleware('can:update-student')->only(['edit', 'update']);
        $this->middleware('can:delete-student')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $this->authorize('view-students');

        $query = Student::query()->with(['marketingAssignee', 'consultantAssignee', 'applicationAssignee']);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($stage = $request->get('stage')) {
            $query->where('current_stage', $stage);
        }

        if ($status = $request->get('status')) {
            $query->where('current_status', $status);
        }

        $students = $query->latest()->paginate(15)->withQueryString();

        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $this->authorize('create-student');

        $users = User::orderBy('name')->get(['id', 'name']);

        return view('admin.students.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->authorize('create-student');

        $validated = $this->validateStudent($request);

        Student::create($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student created successfully.');
    }

    public function edit(Student $student)
    {
        $this->authorize('update-student');

        $users = User::orderBy('name')->get(['id', 'name']);

        return view('admin.students.edit', compact('student', 'users'));
    }

    public function update(Request $request, Student $student)
    {
        $this->authorize('update-student');

        $validated = $this->validateStudent($request);

        $student->update($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $this->authorize('delete-student');

        $student->delete();

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }

    private function validateStudent(Request $request): array
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'dob' => ['nullable', 'date'],
            'country_of_interest' => ['nullable', 'string', 'max:255'],
            'current_stage' => [
                'required',
                Rule::in(['lead', 'counseling', 'payment', 'application', 'offer', 'visa', 'enrolled']),
            ],
            'current_status' => ['nullable', 'string', 'max:50'],
            'assigned_marketing_id' => ['nullable', 'exists:users,id'],
            'assigned_consultant_id' => ['nullable', 'exists:users,id'],
            'assigned_application_id' => ['nullable', 'exists:users,id'],
        ]);
    }
}
