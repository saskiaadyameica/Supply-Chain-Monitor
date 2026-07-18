@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h1 class="fw-bold">
            Currency Dashboard
        </h1>

        <p class="text-secondary">
            Monitor exchange rates of currencies around the world.
        </p>

    </div>
    
    @if($updated)

    <div class="text-end mb-3">

        <small class="text-muted">

            <i class="bi bi-clock-history"></i>

            Last Updated : {{ $updated }}

        </small>

    </div>

    @endif
    <div class="card shadow-sm">

        <div class="card-body">

        <form action="{{ route('currency.check') }}" method="POST">

            @csrf

            <div class="row g-3 align-items-end mb-4">

                {{-- Search --}}
                <div class="col-md-5">

                    <label class="form-label fw-semibold">
                        Search Country
                    </label>

                    <input
                        type="text"
                        id="searchCountry"
                        class="form-control"
                        placeholder="Search country...">

                </div>

                {{-- Amount --}}
                <div class="col-md-2">

                    <label class="form-label fw-semibold">
                        Amount
                    </label>

                    <input
                        type="number"
                        name="amount"
                        class="form-control"
                        value="{{ $amount }}"
                        min="1"
                        step="0.01">

                </div>

                {{-- Base Currency --}}
            <div class="col-md-3">

                <label class="form-label fw-semibold">
                    Base Currency
                </label>

                <select class="form-select" name="base_currency">

                    @foreach($currencies as $currency)

                        <option
                            value="{{ $currency }}"
                            {{ $base == $currency ? 'selected' : '' }}>

                            {{ $currency }}

                        </option>

                    @endforeach

                </select>

            </div>

            </div>

                {{-- Button --}}
                <div class="col-md-4 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-pink w-100">

                        <i class="bi bi-currency-exchange"></i>

                        Check Exchange Rate

                    </button>

                    </form>

                </div>

            </div>

            <hr>

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Exchange Rate Trend
                    </h5>

                    <canvas id="currencyChart" height="100"></canvas>

                </div>

            </div>

            {{-- Currency Table --}}
            <div class="table-responsive">

                <table
                    class="table table-hover align-middle"
                    id="currencyTable">

                    <thead class="table-light">

                        <tr>

                            <th>Flag</th>
                            <th>Country</th>
                            <th>Currency</th>
                            <th>Code</th>
                            <th>Symbol</th>
                            <th>Conversion</th>

                        </tr>

                    </thead>

                    <tbody>

                    @foreach($countries as $country)
                         
                        <tr>

                            <td>
                                <img
                                    src="{{ $country->flag }}"
                                    width="40"
                                    class="rounded border">
                            </td>

                            <td>{{ $country->name }}</td>

                            <td>{{ $country->currency }}</td>

                            <td>{{ $country->currency_code }}</td>

                            <td>{{ $country->currency_symbol }}</td>

                            <td>

                                @if(isset($rates[$country->currency_code]))

                                    {{ rtrim(rtrim(number_format($amount, 2), '0'), '.') }}
                                    {{ $base }}
                                    =
                                    {{ $country->currency_symbol }}
                                    {{ number_format($amount * $rates[$country->currency_code], 2) }}

                                @else

                                    -

                                @endif

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = @json($chartLabels);
const rates = @json($chartRates);

if(labels.length){

    new Chart(document.getElementById('currencyChart'),{

        type:'line',

        data:{

            labels:labels,

            datasets:[{

                label:'USD to IDR',

                data:rates,

                borderWidth:2,

                tension:0.3,

                fill:false

            }]

        }

    });

}

</script>

{{-- Search --}}
<script>

document.getElementById('searchCountry').addEventListener('keyup', function(){

    let value = this.value.toLowerCase();

    let rows = document.querySelectorAll('#currencyTable tbody tr');

    rows.forEach(function(row){

        row.style.display =
            row.innerText.toLowerCase().includes(value)
            ? ''
            : 'none';

    });

});

</script>

@endsection