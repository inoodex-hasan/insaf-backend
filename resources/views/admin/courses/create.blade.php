@extends('admin.layouts.master')

@section('title', 'Create Course')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h2 class="text-xl font-semibold uppercase">Create Course</h2>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary gap-2">Back to List</a>
    </div>

    <div class="panel mt-6">
        <form action="{{ route('admin.courses.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                <div class="form-group">
                    <label>University <span class="text-danger">*</span></label>
                    <select name="university_id" class="form-select" required>
                        <option value="">Select University</option>
                        @foreach ($universities as $university)
                            <option value="{{ $university->id }}"
                                {{ old('university_id') == $university->id ? 'selected' : '' }}>
                                {{ $university->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('university_id')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label>Degree Level</label>
                    <input type="text" name="degree_level" class="form-input" value="{{ old('degree_level') }}">
                </div>

                <div class="form-group">
                    <label>Duration</label>
                    <input type="text" name="duration" class="form-input" value="{{ old('duration') }}">
                </div>

                <div class="form-group">
                    <label>Tuition Fee</label>
                    <input type="number" name="tuition_fee" class="form-input" value="{{ old('tuition_fee') }}">
                </div>

                <div class="form-group">
                    <label>Intake</label>
                    <input type="text" name="intake" class="form-input" value="{{ old('intake') }}">
                </div>

                <div class="form-group">
                    <label>Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

            </div>

            <div class="mt-8 flex items-center gap-4">
                <button type="submit" class="btn btn-primary px-10">Save Course</button>
                <button type="reset" class="btn btn-outline-danger">Reset</button>
            </div>
        </form>
    </div>
@endsection
