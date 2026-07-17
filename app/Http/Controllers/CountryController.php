<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    public function index()
    {
    $search = request('search');

    $countries = Country::when($search, function ($query) use ($search) {

        $query->where('name', 'like', "%{$search}%");

    })
    ->orderBy('name')
    ->paginate(15)
    ->withQueryString();

    return view('countries.index', compact('countries', 'search'));
    }

    public function sync()
    {
        $offset = 0;
        $limit = 100;

        do {

            $response = Http::withoutVerifying()
                ->withToken(config('services.restcountries.key'))
                ->get("https://api.restcountries.com/countries/v5", [

                    'limit' => $limit,

                    'offset' => $offset,

                ]);

            if (!$response->successful()) {

                return back()->with('error', 'Failed to fetch countries.');

            }

            $data = $response->json()['data'];


        foreach ($data['objects'] as $country) {
            
        dd($country['codes']);

                Country::updateOrCreate(

                    [
                        'code' => $country['codes']['alpha_2'] ?? ''
                    ],

                    [

                        'code' => $country['codes']['alpha_2'] ?? '',

                        'name' => $country['names']['common'] ?? '',

                        'capital' => $country['capitals'][0]['name'] ?? '',

                        'region' => $country['region'] ?? '',

                        'population' => $country['population'] ?? 0,

                        'currency' => $country['currencies'][0]['name'] ?? '',

                        'currency_code' => $country['currencies'][0]['code'] ?? '',

                        'currency_symbol' => $country['currencies'][0]['symbol'] ?? '',

                        'flag' => $country['flag']['url_png'] ?? '',

                        'latitude' => $country['coordinates']['lat'] ?? null,

                        'longitude' => $country['coordinates']['lng'] ?? null,
                    ]
                );

                $countryModel = Country::where('code', $country['codes']['alpha_2'])->first();

            }

            $offset += $limit;

        } while ($data['meta']['more']);

        return back()->with(

            'success',

            'Countries synchronized successfully.'

        );
    }
}