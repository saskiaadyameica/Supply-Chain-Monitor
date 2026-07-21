<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;
use App\Services\WorldBankService;
use App\Models\CountryEconomic;

class CountryController extends Controller
{
    private $worldBank;

    public function __construct(WorldBankService $worldBank)
    {
        $this->worldBank = $worldBank;
    }
    
    public function index()
    {
    $search = request('search');

    $countries = Country::with('economics')
        ->when($search, function ($query) use ($search) {

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

    public function syncEconomics()
    {
        $batch = 2;

        $offset = request()->get('offset', 0);

        $countries = Country::whereNotNull('code')
            ->where('code', '!=', '')
            ->orderBy('id')
            ->skip($offset)
            ->take($batch)
            ->get();

        foreach ($countries as $country) {

            $economics = $this->worldBank->getEconomicData($country->code);

            CountryEconomic::updateOrCreate(
                [
                    'country_id' => $country->id,
                ],
                [
                    'gdp' => $economics['gdp'],
                    'inflation' => $economics['inflation'],
                    'export' => $economics['export'],
                    'import' => $economics['import'],
                    'year' => now()->year,
                ]
            );

            usleep(300000);
        }

        $nextOffset = $offset + $countries->count();

        $finished = $nextOffset >= Country::count();

        return response()->json([
            'finished' => $finished,
            'nextOffset' => $nextOffset,
            'processed' => $nextOffset,
            'total' => Country::count(),
        ]);
    }

}