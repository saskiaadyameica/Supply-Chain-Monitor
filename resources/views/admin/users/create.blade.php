@extends('layouts.dashboard')

@section('content')

<div class="dashboard-container">

    <div class="page-header">

        <div>
            <h3 class="fw-bold">Add User</h3>
            <p class="text-secondary">Create a new user account.</p>
        </div>

        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
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

        <form action="{{ route('admin.users.store') }}" method="POST">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">Name</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Password</label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Confirm Password</label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="form-label">Role</label>

                    <select name="role" class="form-select">

                        <option value="user">User</option>

                        <option value="admin">Admin</option>

                    </select>

                </div>

            </div>

            <button type="submit" class="btn btn-pink">
                <i class="bi bi-check-circle me-1"></i>
                Save User
            </button>

        </form>

    </div>

</div>

@endsection