<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WorldBankService
{
    protected $baseUrl = 'https://api.worldbank.org/v2';

    public function getEconomicData($countryCode)
    {
        dd([
            'gdp' => $this->getIndicator($countryCode, 'NY.GDP.MKTP.CD'),
            'inflation' => $this->getIndicator($countryCode, 'FP.CPI.TOTL.ZG'),
            'export' => $this->getIndicator($countryCode, 'NE.EXP.GNFS.CD'),
            'import' => $this->getIndicator($countryCode, 'NE.IMP.GNFS.CD'),
        ]);
        return [
            'gdp' => $this->getIndicator($countryCode, 'NY.GDP.MKTP.CD'),
            'inflation' => $this->getIndicator($countryCode, 'FP.CPI.TOTL.ZG'),
            'export' => $this->getIndicator($countryCode, 'NE.EXP.GNFS.CD'),
            'import' => $this->getIndicator($countryCode, 'NE.IMP.GNFS.CD'),
        ];
    }

    private function getIndicator($countryCode, $indicator)
    {
        try {

            $response = Http::withoutVerifying()
                ->timeout(10)
                ->retry(2, 500)
                ->get(
                    "{$this->baseUrl}/country/{$countryCode}/indicator/{$indicator}",
                    [
                        'format' => 'json',
                        'per_page' => 20,
                    ]
                );

            return $this->extractValue($response);

        } catch (\Throwable $e) {

            logger()->warning('Indicator failed', [
                'country' => $countryCode,
                'indicator' => $indicator,
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    private function extractValue($response)
    {
        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();

        if (!isset($data[1]) || !is_array($data[1])) {
            return null;
        }

        foreach ($data[1] as $row) {
            if (array_key_exists('value', $row) && $row['value'] !== null) {
                return $row['value'];
            }
        }

        return null;
    }
}