@extends('admin.layouts.master')

@section('title', 'Courses')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold uppercase">Courses</h2>
        @can('create-course')
            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">Add Course</a>
        @endcan
    </div>

    <div class="panel">
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>University</th>
                    <th>Name</th>
                    <th>Degree Level</th>
                    <th>Duration</th>
                    <th>Tuition Fee</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $course->university->name ?? 'N/A' }}</td>
                        <td>{{ $course->name ?? 'N/A' }}</td>
                        <td>{{ $course->degree_level ?? 'N/A' }}</td>
                        <td>{{ $course->duration ?? 'N/A' }}</td>
                        <td>{{ $course->tuition_fee ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $course->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $course->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.courses.edit', $course->id) }}"
                                class="btn btn-sm btn-outline-primary">Edit</a>

                            <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">No courses found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $courses->links() }}
        </div>
    </div>

@endsection