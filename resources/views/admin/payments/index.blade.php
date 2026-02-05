@extends('admin.layouts.master')

@section('title', 'Payments')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h2 class="text-xl font-semibold uppercase">Payments</h2>
        @can('create-payment')
            <div class="flex w-full flex-wrap items-center justify-end gap-4 sm:w-auto">
                <a href="{{ route('admin.payments.create') }}" class="btn btn-primary gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="h-5 w-5">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add Payment
                </a>
            </div>
        @endcan
    </div>

    <div class="panel mt-6">
        <div class="mb-5 flex flex-col gap-5 md:flex-row md:items-center">
            <form action="{{ route('admin.payments.index') }}" method="GET"
                class="flex flex-1 flex-col gap-5 md:flex-row md:items-center w-full">
                <div class="relative w-full md:w-[405px]">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search student name, phone or email..." class="form-input ltr:pr-11 rtl:pl-11" />
                    <button type="submit"
                        class="absolute inset-y-0 flex items-center hover:text-primary ltr:right-4 rtl:left-4">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5"
                                opacity="0.5" />
                            <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </button>
                </div>
                <div class="flex gap-2">
                    <select name="payment_type" class="form-select w-full md:w-40 pr-10">
                        <option value="">Type</option>
                        <option value="advance" {{ request('payment_type') == 'advance' ? 'selected' : '' }}>Advance</option>
                        <option value="final" {{ request('payment_type') == 'final' ? 'selected' : '' }}>Final</option>
                    </select>
                    <select name="payment_status" class="form-select w-full md:w-40 pr-10">
                        <option value="">Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('payment_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>

        <div class="datatable">
            <div class="overflow-x-auto">
                <table class="table-hover w-full table-auto">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Collected By</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>
                                    <div class="font-semibold">
                                        {{ $payment->student->first_name }} {{ $payment->student->last_name }}
                                    </div>
                                    <div class="text-xs text-white-dark">{{ $payment->student->phone }}</div>
                                </td>
                                <td class="capitalize">{{ $payment->payment_type }}</td>
                                <td>{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ optional($payment->payment_date)->format('M d, Y') }}</td>
                                <td>
                                    <span
                                        class="badge {{ $payment->payment_status === 'completed' ? 'badge-outline-success' : 'badge-outline-warning' }}">
                                        {{ $payment->payment_status }}
                                    </span>
                                </td>
                                <td>{{ $payment->collector->name ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @can('update-payment')
                                            <a href="{{ route('admin.payments.edit', $payment->id) }}"
                                                class="btn btn-sm btn-outline-primary">Edit</a>
                                        @endcan
                                        @can('delete-payment')
                                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this payment?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No data found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
@endsection
