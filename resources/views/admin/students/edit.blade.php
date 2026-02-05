@extends('admin.layouts.master')

@section('title', 'Edit Student')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h2 class="text-xl font-semibold uppercase">Edit Student</h2>
        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to List
        </a>
    </div>

    <div class="panel mt-6">
        <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="form-group">
                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" id="first_name" class="form-input" required
                        value="{{ old('first_name', $student->first_name) }}" />
                    @error('first_name') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" id="last_name" class="form-input" required
                        value="{{ old('last_name', $student->last_name) }}" />
                    @error('last_name') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="father_name">Father's Name</label>
                    <input type="text" name="father_name" id="father_name" class="form-input"
                        value="{{ old('father_name', $student->father_name) }}" />
                    @error('father_name') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="phone" class="form-input" required
                        value="{{ old('phone', $student->phone) }}" />
                    @error('phone') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-input"
                        value="{{ old('email', $student->email) }}" />
                    @error('email') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" id="dob" class="form-input"
                        value="{{ old('dob', optional($student->dob)->format('Y-m-d')) }}" />
                    @error('dob') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="country_of_interest">Country of Interest</label>
                    <input type="text" name="country_of_interest" id="country_of_interest" class="form-input"
                        value="{{ old('country_of_interest', $student->country_of_interest) }}" />
                    @error('country_of_interest') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="current_stage">Current Stage <span class="text-danger">*</span></label>
                    <select name="current_stage" id="current_stage" class="form-select" required>
                        @foreach (['lead', 'counseling', 'payment', 'application', 'offer', 'visa', 'enrolled'] as $stage)
                            <option value="{{ $stage }}"
                                {{ old('current_stage', $student->current_stage) == $stage ? 'selected' : '' }}>
                                {{ ucfirst($stage) }}
                            </option>
                        @endforeach
                    </select>
                    @error('current_stage') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="current_status">Current Status</label>
                    <input type="text" name="current_status" id="current_status" class="form-input"
                        value="{{ old('current_status', $student->current_status) }}"
                        placeholder="e.g. Interested, Applied, Payment Pending" />
                    @error('current_status') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="assigned_marketing_id">Assigned Marketing</label>
                    <select name="assigned_marketing_id" id="assigned_marketing_id" class="form-select">
                        <option value="">None</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('assigned_marketing_id', $student->assigned_marketing_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_marketing_id') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="assigned_consultant_id">Assigned Consultant</label>
                    <select name="assigned_consultant_id" id="assigned_consultant_id" class="form-select">
                        <option value="">None</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('assigned_consultant_id', $student->assigned_consultant_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_consultant_id') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="assigned_application_id">Assigned Application</label>
                    <select name="assigned_application_id" id="assigned_application_id" class="form-select">
                        <option value="">None</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('assigned_application_id', $student->assigned_application_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_application_id') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-8 flex items-center gap-4">
                <button type="submit" class="btn btn-primary px-10">Update Student</button>
                <button type="button" onclick="window.location.href='{{ route('admin.students.index') }}'"
                    class="btn btn-outline-danger">Cancel</button>
            </div>
        </form>
    </div>
@endsection
