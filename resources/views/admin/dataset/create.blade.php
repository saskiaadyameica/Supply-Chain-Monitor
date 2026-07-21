@extends('layouts.dashboard')

@section('content')

<div class="dashboard-container">

    <div class="page-header">
        <h3 class="fw-bold">Add Port</h3>
    </div>

    <div class="country-card">

        <form action="{{ route('admin.dataset.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label class="form-label">Port Name</label>
                <input type="text"
                       name="PORT_NAME"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Country</label>
                <input type="text"
                       name="COUNTRY"
                       maxlength="2"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Latitude</label>
                <input type="text"
                       name="LATITUDE"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Longitude</label>
                <input type="text"
                       name="LONGITUDE"
                       class="form-control"
                       required>
            </div>

            <button type="submit" class="btn btn-pink">
                Save
            </button>

            <a href="{{ route('admin.dataset.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>

</div>

@endsection