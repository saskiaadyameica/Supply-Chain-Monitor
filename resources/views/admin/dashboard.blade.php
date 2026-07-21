@extends('layouts.dashboard')

@section('content')

<div class="dashboard-container">

    <div class="page-title">
        <p>Admin Dashboard</p>
    </div>

    <div class="admin-grid">

        <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-dark">

            <div class="overview-card">
                <i class="bi bi-people-fill"></i>
                <h3>User</h3>
                <span>Manage Users</span>
            </div>

        </a>

        <a href="{{ route('admin.dataset.index') }}">

            <div class="overview-card">
                <i class="bi bi-geo-alt-fill"></i>
                <h3>Port</h3>
                <span>Manage Dataset</span>
            </div>

        </a>

        <a href="{{ route('admin.articles.index') }}" class="text-decoration-none text-dark">
            <div class="overview-card">
                <i class="bi bi-newspaper"></i>
                <h3>Article</h3>
                <span>Manage Articles</span>
            </div>

        </a>

    </div>

</div>

@endsection