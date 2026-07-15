@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2 class="fw-bold">
            Welcome Back 👋
        </h2>

        <p class="text-secondary">
            Monitor your global supply chain in one dashboard.
        </p>

    </div>

    {{-- Statistics Card --}}

    <div class="stat-grid">

        @include('components.stat-card',[
            'icon'=>'🌍',
            'title'=>'Countries',
            'value'=>'12'
        ])

        @include('components.stat-card',[
            'icon'=>'🌦',
            'title'=>'Weather Alerts',
            'value'=>'3'
        ])

        @include('components.stat-card',[
            'icon'=>'💱',
            'title'=>'Currencies',
            'value'=>'24'
        ])

        @include('components.stat-card',[
            'icon'=>'⚠',
            'title'=>'Risk Score',
            'value'=>'Medium'
        ])

    </div>

    {{-- Analytics --}}

    <div class="dashboard-grid mt-4">

        <div class="chart-card">

            <div class="section-header">

                <h5>GDP Trend</h5>

                <small>Coming Soon</small>

            </div>

            <div class="chart-placeholder">

                📈

            </div>

        </div>

        <div class="chart-card">

            <div class="section-header">

                <h5>Risk Trend</h5>

                <small>Coming Soon</small>

            </div>

            <div class="chart-placeholder">

                📊

            </div>

        </div>

    </div>

    {{-- World Map --}}

    <div class="map-card mt-4">

        <div class="section-header">

            <h5>Global Monitoring Map</h5>

            <small>Leaflet Map</small>

        </div>

        <div class="map-placeholder">

            🌍

        </div>

    </div>

    {{-- News --}}

    <div class="news-card mt-4">

        <div class="section-header">

            <h5>Latest News</h5>

        </div>

        <div class="news-placeholder">

            No news available.

        </div>

    </div>

</div>

@endsection