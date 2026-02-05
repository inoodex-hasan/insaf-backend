@extends('admin.layouts.master')

@section('title', 'Edit Payment')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h2 class="text-xl font-semibold uppercase">Edit Payment</h2>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to List
        </a>
    </div>

    <div class="panel mt-6">
        <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="form-group">
                    <label for="student_id">Student <span class="text-danger">*</span></label>
                    <select name="student_id" id="student_id" class="form-select" required>
                        <option value="">Select Student</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}"
                                {{ old('student_id', $payment->student_id) == $student->id ? 'selected' : '' }}>
                                {{ $student->first_name }} {{ $student->last_name }} ({{ $student->phone }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="amount">Amount <span class="text-danger">*</span></label>
                    <input type="number" name="amount" id="amount" class="form-input" required step="0.01" min="0"
                        value="{{ old('amount', $payment->amount) }}" />
                    @error('amount') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="payment_type">Payment Type <span class="text-danger">*</span></label>
                    <select name="payment_type" id="payment_type" class="form-select" required>
                        <option value="advance" {{ old('payment_type', $payment->payment_type) == 'advance' ? 'selected' : '' }}>
                            Advance</option>
                        <option value="final" {{ old('payment_type', $payment->payment_type) == 'final' ? 'selected' : '' }}>
                            Final</option>
                    </select>
                    @error('payment_type') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="payment_date">Payment Date <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="payment_date" id="payment_date" class="form-input" required
                        value="{{ old('payment_date', optional($payment->payment_date)->format('Y-m-d\\TH:i')) }}" />
                    @error('payment_date') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="payment_status">Payment Status <span class="text-danger">*</span></label>
                    <select name="payment_status" id="payment_status" class="form-select" required>
                        <option value="pending" {{ old('payment_status', $payment->payment_status) == 'pending' ? 'selected' : '' }}>
                            Pending</option>
                        <option value="completed" {{ old('payment_status', $payment->payment_status) == 'completed' ? 'selected' : '' }}>
                            Completed</option>
                    </select>
                    @error('payment_status') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="receipt_number">Receipt Number</label>
                    <input type="text" name="receipt_number" id="receipt_number" class="form-input"
                        value="{{ old('receipt_number', $payment->receipt_number) }}" />
                    @error('receipt_number') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="collected_by">Collected By</label>
                    <select name="collected_by" id="collected_by" class="form-select">
                        <option value="">Keep Current</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('collected_by', $payment->collected_by) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('collected_by') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-8 flex items-center gap-4">
                <button type="submit" class="btn btn-primary px-10">Update Payment</button>
                <button type="button" onclick="window.location.href='{{ route('admin.payments.index') }}'"
                    class="btn btn-outline-danger">Cancel</button>
            </div>
        </form>
    </div>
@endsection
