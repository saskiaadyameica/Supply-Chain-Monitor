<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Country;

class CurrencyController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('name')->get();

        $currencies = Country::select('currency_code')
            ->whereNotNull('currency_code')
            ->where('currency_code', '!=', '')
            ->distinct()
            ->orderBy('currency_code')
            ->pluck('currency_code');

        $rates = [];

        $base = 'USD';

        $amount = 1;

        $updated = null;

        $chartLabels = [];

        $chartRates = [];

        return view('currency.index', compact(
            'countries',
            'currencies',
            'rates',
            'base',
            'amount',
            'updated',
            'chartLabels',
            'chartRates'

        ));
    }

    public function check(Request $request)
    {
        $base = $request->base_currency;

        $amount = $request->amount ?? 1;

        $response = Http::withoutVerifying()->get(
            "https://open.er-api.com/v6/latest/{$base}"
        );

        $rates = [];

        $updated = null;

        $chartLabels = [];

        $chartRates = [];

        if ($response->successful()) {

            $rates = $response['rates'];

            $updated = $response['time_last_update_utc'] ?? null;

        }

        // Historical Exchange Rate (7 Days)
        $to = now()->format('Y-m-d');
        $from = now()->subDays(6)->format('Y-m-d');

        $targetCurrency = 'IDR';

        if ($base != 'IDR') {

            $history = Http::withoutVerifying()->get(
                "https://api.frankfurter.app/{$from}..{$to}",
                [
                    'from' => $base,
                    'to'   => $targetCurrency
                ]
            );

        } else {

            $targetCurrency = 'USD';

            $history = Http::withoutVerifying()->get(
                "https://api.frankfurter.app/{$from}..{$to}",
                [
                    'from' => 'IDR',
                    'to'   => 'USD'
                ]
            );

        }

        if ($history->successful()) {

            foreach ($history['rates'] as $date => $rate) {

                $chartLabels[] = date('d M', strtotime($date));

                $chartRates[] = array_values($rate)[0];

            }

        }

        $countries = Country::orderBy('name')->get();

        $currencies = Country::select('currency_code')
            ->whereNotNull('currency_code')
            ->where('currency_code', '!=', '')
            ->distinct()
            ->orderBy('currency_code')
            ->pluck('currency_code');

        return view('currency.index', compact(
            'countries',
            'currencies',
            'rates',
            'base',
            'amount',
            'updated',
            'chartLabels',
            'chartRates'
        ));
    }

}