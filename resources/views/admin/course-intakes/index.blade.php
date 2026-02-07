@extends('admin.layouts.master')

@section('title', 'Course Intakes')

@section('content')

    <div class="mb-5 flex items-center justify-between">
        <h2 class="text-xl font-semibold">Course Intakes</h2>
        <a href="{{ route('admin.course-intakes.create') }}" class="btn btn-primary">
            Add Intake
        </a>
    </div>

    <div class="panel">
        <div class="table-responsive">
            <table class="table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>University</th>
                        <th>Course</th>
                        <th>Intake</th>
                        <th>Application Start</th>
                        <th>Deadline</th>
                        <th>Class Start</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($intakes as $intake)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $intake->course->university->name ?? 'N/A' }}</td>
                            <td>{{ $intake->course->name ?? 'N/A' }}</td>
                            <td>{{ $intake->intake_name ?? 'N/A' }}</td>
                            <td>{{ $intake->application_start_date?->format('d M Y') ?? 'N/A' }}</td>
                            <td>{{ $intake->application_deadline?->format('d M Y') ?? 'N/A' }}</td>
                            <td>{{ $intake->class_start_date?->format('d M Y') ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $intake->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $intake->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.course-intakes.edit', $intake->id) }}"
                                    class="btn btn-sm btn-outline-primary">Edit</a>

                                <form action="{{ route('admin.course-intakes.destroy', $intake->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No intakes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $intakes->links() }}
        </div>
    </div>

@endsection