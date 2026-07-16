@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Countries
            </h2>

            <p class="text-secondary mb-0">
                Global Country Dashboard

        </div>

        <form action="{{ route('countries.sync') }}" method="POST">

            @csrf

            <button class="btn btn-pink">

                Sync Countries

            </button>

        </form>

    </div>

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

    <div class="card country-card">

        <div class="card-body">

            <form action="{{ route('countries.index') }}" method="GET" class="mb-4">

                <div class="row">

                    <div class="col-md-5">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control search-box"
                            placeholder="Search country">

                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table country-table align-middle">

                    <thead>

                        <tr>

                            <th width="260">Country</th>

                            <th width="180">Capital</th>

                            <th width="150">Region</th>

                            <th width="220">Currency</th>

                            <th class="text-end" width="170">
                                Population
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($countries as $country)

                        <tr>

                            <td>
                                <div class="country-info">

                                    <img
                                        src="{{ $country->flag }}"
                                        class="country-flag">

                                    <span class="country-name">

                                        {{ $country->name }}

                                    </span>

                                </div>

                            </td>

                            <td>

                                {{ $country->capital }}

                            </td>

                            <td>

                                {{ $country->region }}

                            </td>

                            <td>

                                {{ $country->currency }}

                            </td>

                            <td class="text-end">

                                {{ number_format($country->population) }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6" class="text-center py-5 text-secondary">

                                No country data available.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">

                <div class="text-muted">

                </div>

                {{ $countries->links() }}

            </div>

        </div>

    </div>

</div>

@endsection