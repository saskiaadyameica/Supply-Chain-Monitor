@extends('layouts.dashboard')

@section('content')

<div class="dashboard-container">

    <div class="page-header d-flex justify-content-between align-items-center">

        <div>
            <h3 class="fw-bold mb-1">Port Dataset</h3>
            <p class="text-secondary">
                Upload dataset or manage port data.
            </p>
        </div>

        <a href="{{ route('admin.dataset.create') }}"
           class="btn btn-pink">

            <i class="bi bi-plus-circle"></i>

            Add Port

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    @if($errors->any())

        <div class="alert alert-danger">

            {{ $errors->first() }}

        </div>

    @endif

    <div class="country-card mb-4">

        <form action="{{ route('admin.dataset.upload') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="row align-items-end">

                <div class="col-md-9">

                    <label class="form-label">

                        Upload CSV

                    </label>

                    <input type="file"
                           name="dataset"
                           class="form-control"
                           accept=".csv"
                           required>

                </div>

                <div class="col-md-3">

                    <button class="btn btn-pink w-100">

                        Upload

                    </button>

                </div>

            </div>

        </form>

    </div>

    <div class="country-card">

        <table class="table table-hover">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Port</th>
                    <th>Country</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th width="170">Action</th>

                </tr>

            </thead>

            <tbody>

            @foreach($ports as $port)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $port['PORT_NAME'] }}</td>

                    <td>{{ $port['COUNTRY'] }}</td>

                    <td>{{ $port['LATITUDE'] }}</td>

                    <td>{{ $port['LONGITUDE'] }}</td>

                    <td>

                        <a href="{{ route('admin.dataset.edit',$port['id']) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form
                            action="{{ route('admin.dataset.destroy',$port['id']) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this port?')">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection