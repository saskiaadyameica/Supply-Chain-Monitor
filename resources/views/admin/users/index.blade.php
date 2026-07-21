@extends('layouts.dashboard')

@section('content')

<div class="dashboard-container">

    <div class="page-header">

        <div>
            <h3 class="fw-bold mb-1">Users Management</h3>
            <p class="text-secondary mb-0">
                Manage registered users.
            </p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="btn btn-pink">
            <i class="bi bi-plus-lg"></i>
            Add User
        </a>

    </div>

    <div class="country-card">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

        <table class="country-table">

            <thead>

                <tr>
                    <th width="70">No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="120">Role</th>
                    <th width="160">Action</th>
                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td class="fw-semibold">
                        {{ $user->name }}
                    </td>

                    <td>{{ $user->email }}</td>

                    <td>

                        @if($user->role=='admin')

                            <span class="badge text-bg-danger">
                                Admin
                            </span>

                        @else

                            <span class="badge text-bg-secondary">
                                User
                            </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form action="{{ route('admin.users.destroy', $user) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Are you sure you want to delete this user?')">

                                <i class="bi bi-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="text-center py-4">
                        No users found.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection