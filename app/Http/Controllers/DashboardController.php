<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        // Total countries
        $totalCountries = Country::count();

        // Default weather: Indonesia
        $country = Country::where('name', 'Indonesia')->first();

        $weather = null;
        $weatherIcon = null;

        if ($country) {

            $response = Http::withoutVerifying()->get(
                'https://api.open-meteo.com/v1/forecast',
                [
                    'latitude' => $country->latitude,
                    'longitude' => $country->longitude,
                    'current' => 'temperature_2m,weather_code',
                    'timezone' => 'auto',
                ]
            );
            
            if ($response->successful()) {

                $weather = $response['current'];
    
                $weatherCode = $weather['weather_code'] ?? 0;

                $weatherIcon = match (true) {

                    in_array($weatherCode,[0]) => [
                        'icon' => 'bi bi-brightness-high-fill',
                        'text' => 'Sunny',
                    ],

                    in_array($weatherCode,[1,2]) => [
                        'icon' => 'bi bi-cloud-sun-fill',
                        'text' => 'Partly Cloudy',
                    ],

                    in_array($weatherCode,[3]) => [
                        'icon' => 'bi bi-cloud-fill',
                        'text' => 'Cloudy',
                    ],

                    in_array($weatherCode,[45,48]) => [
                        'icon' => 'bi bi-cloud-fog2-fill',
                        'text' => 'Fog',
                    ],

                    in_array($weatherCode,[51,53,55,61,63,65,80,81,82]) => [
                        'icon' => 'bi bi-cloud-rain-heavy-fill',
                        'text' => 'Rain',
                    ],

                    in_array($weatherCode,[71,73,75,77]) => [
                        'icon' => 'bi bi-cloud-snow-fill',
                        'text' => 'Snow',
                    ],

                    in_array($weatherCode,[95,96,99]) => [
                        'icon' => 'bi bi-cloud-lightning-rain-fill',
                        'text' => 'Thunderstorm',
                    ],

                    default => [
                        'icon' => 'bi bi-question-circle-fill',
                        'text' => 'Unknown',
                    ],
                };
            }
        }

        return view('dashboard.index', compact(
            'totalCountries',
            'weather',
            'weatherIcon'
        ));
    }
}