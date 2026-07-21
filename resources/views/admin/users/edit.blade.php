@extends('layouts.dashboard')

@section('content')

<div class="dashboard-container">

    <div class="page-header">

        <div>
            <h3 class="fw-bold mb-1">Edit User</h3>
            <p class="text-secondary mb-0">
                Update user information.
            </p>
        </div>

        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>

    </div>

    <div class="country-card">

        @if ($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">Name</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $user->name) }}"
                        required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $user->email) }}"
                        required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">New Password</label>

                    <input
                        type="password"
                        name="password"
                        class="form-control">

                    <small class="text-secondary">
                        Leave blank if you don't want to change the password.
                    </small>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Confirm Password</label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control">

                </div>

                <div class="col-md-6 mb-4">

                    <label class="form-label">Role</label>

                    <select name="role" class="form-select">

                        <option value="user"
                            {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>
                            User
                        </option>

                        <option value="admin"
                            {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                    </select>

                </div>

            </div>

            <button type="submit" class="btn btn-pink">
                <i class="bi bi-check-circle me-1"></i>
                Update User
            </button>

        </form>

    </div>

</div>

@endsection