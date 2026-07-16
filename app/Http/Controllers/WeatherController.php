<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('name')->get();

        return view(
            'weather.index', 
            compact('countries'));
    }

    public function check(Request $request)
    {
        $countries = Country::orderBy('name')->get();

        $country = Country::findOrFail($request->country_id);

        $response = Http::withoutVerifying()->get(
            'https://api.open-meteo.com/v1/forecast',
            [
                'latitude' => $country->latitude,
                'longitude' => $country->longitude,
                'current' => 'temperature_2m,wind_speed_10m,rain',
                'timezone' => 'auto',
            ]
        );

        $weather = $response->json()['current'];

        return view(
            'weather.index',
            compact(
                'countries',
                'country',
                'weather'
            )
        );
    }
}