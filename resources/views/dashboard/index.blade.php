@extends('layouts.dashboard')

@section('content')

<div class="dashboard-container">

    <div class="page-title">


        <p>
            Supply Chain Overview
        </p>

    </div>

    <!-- Overview -->

    <div class="overview-grid">

        <div class="overview-card">

            <i class="bi bi-globe2"></i>

            <h3>{{ $totalCountries }}</h3>

            <span>Countries</span>

        </div>

        <div class="overview-card">

            <i class="bi bi-cloud-sun"></i>

            <h3>Live</h3>

            <span>Weather</span>

        </div>

        <div class="overview-card">

            <i class="bi bi-newspaper"></i>

            <h3>0</h3>

            <span>News</span>

        </div>

        <div class="overview-card">

            <i class="bi bi-shield-check"></i>

            <h3>Low</h3>

            <span>Risk</span>

        </div>

    </div>

    <!-- Bottom -->

    <div class="bottom-grid">

        <div class="panel-card">

            <h5>Latest Global News</h5>

            <hr>

            <p>No news available.</p>

        </div>

        <div class="panel-card">

            <h5>High Risk Countries</h5>

            <hr>

            <p>No risk analysis available.</p>

        </div>

    </div>

</div>

    <div class="chart-section mt-4">

        <h4 class="mb-4 fw-bold">
            Data Visualization
        </h4>

        <div class="chart-grid">

            <div class="chart-card">

                <h6>GDP Trend</h6>

                <canvas id="gdpChart"></canvas>

            </div>

            <div class="chart-card">

                <h6>Inflation Trend</h6>

                <canvas id="inflationChart"></canvas>

            </div>

            <div class="chart-card">

                <h6>Currency Trend</h6>

                <canvas id="currencyChart"></canvas>

            </div>

            <div class="chart-card">

                <h6>Risk Trend</h6>

                <canvas id="riskChart"></canvas>

            </div>

        </div>

    </div>

@endsection

@push('scripts')

<script>

const chartData = {

labels:['Jan','Feb','Mar','Apr','May','Jun'],

datasets:[{

data:[12,18,14,20,16,24],

borderColor:'#D98CA3',

backgroundColor:'rgba(217,140,163,.2)',

fill:true,

tension:.4

}]

};

new Chart(document.getElementById('gdpChart'),{

type:'line',

data:chartData

});

new Chart(document.getElementById('inflationChart'),{

type:'line',

data:chartData

});

new Chart(document.getElementById('currencyChart'),{

type:'line',

data:chartData

});

new Chart(document.getElementById('riskChart'),{

type:'line',

data:chartData

});

</script>

@endpush