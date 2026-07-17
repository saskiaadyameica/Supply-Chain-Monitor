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

                <div class="row align-items-end mb-4">

                    <div class="col-md-8">

                        <label class="form-label fw-semibold">
                            Select Country
                        </label>

                        <select
                                id="countrySelect"
                                name="country_id"
                                class="form-select">

                            @foreach($countries as $item)

                                <option
                                    value="{{ $item->id }}"
                                    {{ isset($country) && $country->id==$item->id ? 'selected' : '' }}>

                                    {{ $item->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-4">
                                <button
                                    type="submit"
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

            {{-- Weather Status --}}
            <div class="col-md-3">

                <div class="card text-center shadow-sm border-0 rounded-4 h-100">

                    <div class="card-body d-flex flex-column justify-content-center">

                        <i class="{{ $weatherIcon['icon'] }}"
                        style="font-size:60px;color:#f5b400;"></i>

                        <h5 class="fw-bold mt-3 mb-1">

                            {{ $weatherIcon['text'] }}

                        </h5>

                        <h2 class="fw-bold text-primary">

                            {{ $weather['temperature_2m'] }}°C

                        </h2>

                    </div>

                </div>

            </div>

            {{-- Wind --}}
            <div class="col-md-3">

                <div class="card text-center shadow-sm border-0 rounded-4 h-100">

                    <div class="card-body d-flex flex-column justify-content-center">

                        <i class="bi bi-wind"
                        style="font-size:45px;color:#6c63ff;"></i>

                        <h6 class="text-secondary mt-3">

                            Wind Speed

                        </h6>

                        <h2 class="fw-bold">

                            {{ $weather['wind_speed_10m'] }}

                        </h2>

                        <small class="text-muted">

                            km/h

                        </small>

                    </div>

                </div>

            </div>

            {{-- Rain --}}
            <div class="col-md-3">

                <div class="card text-center shadow-sm border-0 rounded-4 h-100">

                    <div class="card-body d-flex flex-column justify-content-center">

                        <i class="bi bi-cloud-rain-fill"
                        style="font-size:45px;color:#2b7de9;"></i>

                        <h6 class="text-secondary mt-3">

                            Rainfall

                        </h6>

                        <h2 class="fw-bold">

                            {{ $rainfall }}

                        </h2>

                        <small class="text-muted">

                            mm

                        </small>

                    </div>

                </div>

            </div>

            {{-- Storm --}}
            <div class="col-md-3">

                <div class="card text-center shadow-sm border-0 rounded-4 h-100">

                    <div class="card-body d-flex flex-column justify-content-center">

                        @php

                            if($weather['wind_speed_10m'] >= 40){

                                $stormIcon="bi-cloud-lightning-rain-fill";
                                $stormText="High";

                            }elseif($weather['wind_speed_10m'] >=20){

                                $stormIcon="bi-cloud-lightning-fill";
                                $stormText="Medium";

                            }else{

                                $stormIcon="bi-shield-check";
                                $stormText="Low";

                            }

                        @endphp

                        <i class="bi {{ $stormIcon }}"
                        style="font-size:45px;color:#ff7b00;"></i>

                        <h6 class="text-secondary mt-3">

                            Storm Risk

                        </h6>

                        <h2 class="fw-bold">

                            {{ $stormText }}

                        </h2>

                    </div>

                </div>

            </div>

        </div>

            <hr class="my-5">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <h4 class="fw-bold mb-4">

                        Weather Map

                    </h4>

                    <div id="weatherMap"></div>

                </div>

            </div>

            @endisset

        </div>

    </div>

</div>

@endsection

@push('scripts')

@if(isset($country))

<script>

document.addEventListener("DOMContentLoaded", function () {

    const map = L.map('weatherMap').setView(
        [
            {{ $country->latitude }},
            {{ $country->longitude }}
        ],
        5
    );

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution: '© OpenStreetMap'
        }
    ).addTo(map);

    L.marker([
        {{ $country->latitude }},
        {{ $country->longitude }}
    ])
    .addTo(map)
    .bindPopup(`
        <b>{{ $country->name }}</b><br>
        Temperature : {{ $weather['temperature_2m'] }} °C<br>
        Wind : {{ $weather['wind_speed_10m'] }} km/h<br>
        Rain : {{ $rainfall }} mm
    `)
    .openPopup();

});

</script>

@endif

<script>

$(document).ready(function(){

    $('#countrySelect').select2({

        placeholder:'Search country...',

        width:'100%'

    });

});

</script>

@endpush
            