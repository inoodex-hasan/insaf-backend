@extends('admin.layouts.master')

@section('title', 'Countries')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold uppercase">Countries</h2>
        <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">Add Country</a>
    </div>

    <div class="panel">
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Currency</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($countries as $country)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $country->name }}</td>
                        <td>{{ $country->code ?? 'N/A' }}</td>
                        <td>{{ $country->currency ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $country->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $country->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.countries.edit', $country->id) }}"
                                class="btn btn-sm btn-outline-primary">Edit</a>

                            <form action="{{ route('admin.countries.destroy', $country->id) }}" method="POST"
                                class="inline-block" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No countries found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $countries->links() }}
        </div>
    </div>

@endsection