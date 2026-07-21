@extends('layouts.dashboard')

@section('content')

<div class="page-header">

    <div>

        <h2 class="fw-bold mb-1">
            Countries
        </h2>

            <p class="text-secondary mb-0">
                Global Country Dashboard

        </div>

        <div class="d-flex gap-2">

            <form action="{{ route('countries.sync') }}" method="POST">
                @csrf

                <button type="submit" class="btn btn-pink">
                    <i class="bi bi-arrow-repeat me-2"></i>
                    Sync Countries
                </button>
            </form>

            <button
                id="syncEconomicsBtn"
                class="btn-pink">
                Sync Economic Data
            </button>
            
            <div id="syncStatus" class="mt-3" style="display:none;">

            <div class="progress">

                <div
                    id="syncBar"
                    class="progress-bar progress-bar-striped progress-bar-animated"
                    style="width:0%">

                    0%

                </div>

            </div>

            <small id="syncText">
                Preparing...
            </small>

        </div>

        </div>

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
                            <th class="text-end">GDP</th>

                            <th class="text-end">Inflation</th>

                            <th class="text-end">Export</th>

                            <th class="text-end">Import</th>
                           
                        </th>

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

                            <td class="text-end">

                                @if($country->economics && $country->economics->gdp)

                                    {{ number_format($country->economics->gdp, 0) }}

                                @else

                                    -

                                @endif

                            </td>

                            <td class="text-end">

                                @if($country->economics && $country->economics->inflation)

                                    {{ number_format($country->economics->inflation, 2) }}%

                                @else

                                    -

                                @endif

                            </td>

                            <td class="text-end">

                                @if($country->economics && $country->economics->export)

                                    {{ number_format($country->economics->export, 0) }}

                                @else

                                    -

                                @endif

                            </td>

                            <td class="text-end">

                                @if($country->economics && $country->economics->import)

                                    {{ number_format($country->economics->import, 0) }}

                                @else

                                    -

                                @endif

                            </td>

                            

                        </tr>

                        @empty

                        <tr>

                            <td colspan="9" class="text-center py-5 text-secondary">

                                No country data available.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">

                <div class="text-secondary">
                    Showing {{ $countries->firstItem() }}
                    to {{ $countries->lastItem() }}
                    of {{ $countries->total() }} results
               
                </div>

                {{ $countries->links() }}

            </div>

        </div>

    </div>

</div>

<script>

const totalCountries = {{ \App\Models\Country::count() }};

async function syncBatch(offset = 0)
{
    const response = await fetch(
        "{{ route('countries.syncEconomics') }}?offset=" + offset,
        {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        }
    );

    const data = await response.json();

    let percent = Math.round((data.processed / data.total) * 100);

    document.getElementById("syncBar").style.width = percent + "%";
    document.getElementById("syncBar").innerHTML = percent + "%";

    document.getElementById("syncText").innerHTML =
        data.processed + " / " + data.total + " countries synchronized";

    if (!data.finished) {

        setTimeout(function () {

            syncBatch(data.nextOffset);

        }, 500);

    } else {

        document.getElementById("syncText").innerHTML =
            "✅ Synchronization completed.";

        setTimeout(function () {

            location.reload();

        }, 1000);

    }
}

document.getElementById("syncEconomicsBtn").onclick=function(){

    document.getElementById("syncStatus").style.display="block";

    this.disabled=true;

    syncBatch();

}

</script>

@endsection