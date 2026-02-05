@extends('admin.layouts.master')

@section('title', 'Universities')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold uppercase">Universities</h2>
        @can('create-university')
            <a href="{{ route('admin.universities.create') }}" class="btn btn-primary">Add University</a>
        @endcan
    </div>

    <div class="panel">
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Country</th>
                    <th>Name</th>
                    <th>Short Name</th>
                    <th>Email</th>
                    <th>Website</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($universities as $university)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $university->country->name ?? '-' }}</td>
                        <td>{{ $university->name }}</td>
                        <td>{{ $university->short_name }}</td>
                        <td>{{ $university->email }}</td>
                        <td>{{ $university->website }}</td>
                        <td>
                            <span class="badge {{ $university->status ? 'badge-success' : 'badge-danger' }}">
                                {{ $university->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-center">
                            @can('update-university')
                                <a href="{{ route('admin.universities.edit', $university->id) }}"
                                    class="btn btn-sm btn-outline-primary">Edit</a>
                            @endcan
                            @can('delete-university')
                                <form action="{{ route('admin.universities.destroy', $university->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">No universities found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $universities->links() }}
        </div>
    </div>

@endsection
