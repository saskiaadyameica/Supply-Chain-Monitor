@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h1 class="fw-bold">
            Weather Monitoring
        </h1>

        <p class="text-secondary">
            Monitor current weather conditions by country.
        </p>

    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card country-card">

        <div class="card-body">

            <form action="{{ route('weather.check') }}" method="POST">

                @csrf

                <div class="row align-items-end">

                    <div class="col-md-8">

                        <label class="form-label fw-semibold">
                            Select Country
                        </label>

                        <select
                            name="country_id"
                            class="form-select form-select-lg"
                            required>

                            @foreach($countries as $item)

                                <option
                                    value="{{ $item->id }}"
                                    @selected(isset($country) && $country->id == $item->id)>

                                    {{ $item->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-4">

                        <button
                            class="btn btn-pink w-100">

                            Check Weather

                        </button>

                    </div>

                </div>

            </form>

            @isset($country)

            <hr class="my-5">

            <div class="mb-4">

                <h4 class="fw-bold">

                    {{ $country->name }}

                </h4>

                <span class="text-secondary">

                    {{ $country->capital }}

                </span>

            </div>

            <div class="row g-4">

                <div class="col-md-3">

                    <div class="card text-center shadow-sm border-0 rounded-4">

                        <div class="card-body">

                            <h6 class="text-secondary">
                                Temperature
                            </h6>

                            <h2 class="fw-bold">

                                {{ $weather['temperature_2m'] }} °C

                            </h2>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card text-center shadow-sm border-0 rounded-4">

                        <div class="card-body">

                            <h6 class="text-secondary">
                                Wind Speed
                            </h6>

                            <h2 class="fw-bold">

                                {{ $weather['wind_speed_10m'] }} km/h

                            </h2>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card text-center shadow-sm border-0 rounded-4">

                        <div class="card-body">

                            <h6 class="text-secondary">
                                Rainfall
                            </h6>

                            <h2 class="fw-bold">

                                {{ $weather['rain'] }} mm

                            </h2>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card text-center shadow-sm border-0 rounded-4">

                        <div class="card-body">

                            <h6 class="text-secondary">
                                Storm Risk
                            </h6>

                            <h2 class="fw-bold">

                                @if($weather['wind_speed_10m'] >= 40)

                                    High

                                @elseif($weather['wind_speed_10m'] >= 20)

                                    Medium

                                @else

                                    Low

                                @endif

                            </h2>

                        </div>

                    </div>

                </div>

            </div>

            @endisset

        </div>

    </div>

</div>

@endsection