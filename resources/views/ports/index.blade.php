@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h1 class="fw-bold">
            Port Location Dashboard
        </h1>

        <p class="text-secondary">
            Explore port locations around the world.
        </p>

    </div>

    <form action="{{ route('ports.index') }}" method="GET" class="row mb-4">

        <div class="col-md-5">
            <input
                type="text"
                name="port"
                class="form-control"
                placeholder="Search Port"
                value="{{ request('port') }}">
        </div>

        <div class="col-md-5">
            <input
                type="text"
                name="country"
                class="form-control"
                placeholder="Search Country"
                value="{{ request('country') }}">
        </div>

        <div class="col-md-2">

            <button
                class="w-100"
                style="
                    background-color:#d88ca2;
                    border:1px solid #d88ca2;
                    color:white;
                    border-radius:10px;
                    padding:8px 0;
                    transition:0.3s;
                "
                onmouseover="this.style.backgroundColor='#c9758d';this.style.borderColor='#c9758d';"
                onmouseout="this.style.backgroundColor='#d88ca2';this.style.borderColor='#d88ca2';">
                Search
            </button>

        </div>

    </form>

    <div class="card shadow-sm">

        <div class="card-body">

            <div id="map" style="height:600px;"></div>

        </div>

        <div class="card mt-4">

            <div class="card-header">
                Port List
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <thead>

                        <tr>
                            <th>Port</th>
                            <th>Country</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($ports as $item)

                        <tr>

                        <td>{{ $item['port_name'] }}</td>
                        <td>{{ $item['country'] }}</td>
                        <td>{{ $item['latitude'] }}</td>
                        <td>{{ $item['longitude'] }}</td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="4" class="text-center">
                                No data
                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>



@endsection

@push('scripts')

<script>

var map = L.map('map').setView([20, 0], 2);

L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        attribution: '&copy; OpenStreetMap'
    }
).addTo(map);

const ports = @json($ports);

ports.forEach(function(port){

    L.marker([port.latitude, port.longitude])
        .addTo(map)
        .bindPopup(`
            <b>${port.port_name}</b><br>
            ${port.country}
        `);

});

if(ports.length > 0){

    map.setView([ports[0].latitude, ports[0].longitude], 6);

}

</script>

@endpush