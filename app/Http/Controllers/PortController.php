<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortController extends Controller
{
    public function index(Request $request)
    {
        $ports = [];

        $portSearch = strtolower(trim($request->port));
        $countrySearch = strtolower(trim($request->country));
 
        $countryMap = [
            'afghanistan' => 'AF',
            'albania' => 'AL',
            'algeria' => 'DZ',
            'andorra' => 'AD',
            'angola' => 'AO',
            'argentina' => 'AR',
            'armenia' => 'AM',
            'australia' => 'AU',
            'austria' => 'AT',
            'azerbaijan' => 'AZ',
            'bahamas' => 'BS',
            'bahrain' => 'BH',
            'bangladesh' => 'BD',
            'barbados' => 'BB',
            'belarus' => 'BY',
            'belgium' => 'BE',
            'belize' => 'BZ',
            'benin' => 'BJ',
            'bhutan' => 'BT',
            'bolivia' => 'BO',
            'bosnia and herzegovina' => 'BA',
            'botswana' => 'BW',
            'brazil' => 'BR',
            'brunei' => 'BN',
            'bulgaria' => 'BG',
            'burkina faso' => 'BF',
            'burundi' => 'BI',
            'cambodia' => 'KH',
            'cameroon' => 'CM',
            'canada' => 'CA',
            'cape verde' => 'CV',
            'central african republic' => 'CF',
            'chad' => 'TD',
            'chile' => 'CL',
            'china' => 'CN',
            'colombia' => 'CO',
            'comoros' => 'KM',
            'congo' => 'CG',
            'costa rica' => 'CR',
            'croatia' => 'HR',
            'cuba' => 'CU',
            'cyprus' => 'CY',
            'czech republic' => 'CZ',
            'denmark' => 'DK',
            'djibouti' => 'DJ',
            'dominica' => 'DM',
            'dominican republic' => 'DO',
            'ecuador' => 'EC',
            'egypt' => 'EG',
            'el salvador' => 'SV',
            'eritrea' => 'ER',
            'estonia' => 'EE',
            'eswatini' => 'SZ',
            'ethiopia' => 'ET',
            'fiji' => 'FJ',
            'finland' => 'FI',
            'france' => 'FR',
            'gabon' => 'GA',
            'gambia' => 'GM',
            'georgia' => 'GE',
            'germany' => 'DE',
            'ghana' => 'GH',
            'greece' => 'GR',
            'greenland' => 'GL',
            'guatemala' => 'GT',
            'guinea' => 'GN',
            'guyana' => 'GY',
            'haiti' => 'HT',
            'honduras' => 'HN',
            'hungary' => 'HU',
            'iceland' => 'IS',
            'india' => 'IN',
            'indonesia' => 'ID',
            'iran' => 'IR',
            'iraq' => 'IQ',
            'ireland' => 'IE',
            'israel' => 'IL',
            'italy' => 'IT',
            'jamaica' => 'JM',
            'japan' => 'JP',
            'jordan' => 'JO',
            'kazakhstan' => 'KZ',
            'kenya' => 'KE',
            'kiribati' => 'KI',
            'kuwait' => 'KW',
            'kyrgyzstan' => 'KG',
            'laos' => 'LA',
            'latvia' => 'LV',
            'lebanon' => 'LB',
            'lesotho' => 'LS',
            'liberia' => 'LR',
            'libya' => 'LY',
            'liechtenstein' => 'LI',
            'lithuania' => 'LT',
            'luxembourg' => 'LU',
            'madagascar' => 'MG',
            'malawi' => 'MW',
            'malaysia' => 'MY',
            'maldives' => 'MV',
            'mali' => 'ML',
            'malta' => 'MT',
            'marshall islands' => 'MH',
            'mauritania' => 'MR',
            'mauritius' => 'MU',
            'mexico' => 'MX',
            'micronesia' => 'FM',
            'moldova' => 'MD',
            'mongolia' => 'MN',
            'montenegro' => 'ME',
            'morocco' => 'MA',
            'mozambique' => 'MZ',
            'myanmar' => 'MM',
            'namibia' => 'NA',
            'nauru' => 'NR',
            'nepal' => 'NP',
            'netherlands' => 'NL',
            'new zealand' => 'NZ',
            'nicaragua' => 'NI',
            'niger' => 'NE',
            'nigeria' => 'NG',
            'north korea' => 'KP',
            'norway' => 'NO',
            'oman' => 'OM',
            'pakistan' => 'PK',
            'palau' => 'PW',
            'panama' => 'PA',
            'papua new guinea' => 'PG',
            'paraguay' => 'PY',
            'peru' => 'PE',
            'philippines' => 'PH',
            'poland' => 'PL',
            'portugal' => 'PT',
            'qatar' => 'QA',
            'romania' => 'RO',
            'russia' => 'RU',
            'russian federation' => 'RU',
            'rwanda' => 'RW',
            'saudi arabia' => 'SA',
            'senegal' => 'SN',
            'serbia' => 'RS',
            'seychelles' => 'SC',
            'sierra leone' => 'SL',
            'singapore' => 'SG',
            'slovakia' => 'SK',
            'slovenia' => 'SI',
            'solomon islands' => 'SB',
            'somalia' => 'SO',
            'south africa' => 'ZA',
            'south korea' => 'KR',
            'south sudan' => 'SS',
            'spain' => 'ES',
            'sri lanka' => 'LK',
            'sudan' => 'SD',
            'suriname' => 'SR',
            'sweden' => 'SE',
            'switzerland' => 'CH',
            'syria' => 'SY',
            'taiwan' => 'TW',
            'tajikistan' => 'TJ',
            'tanzania' => 'TZ',
            'thailand' => 'TH',
            'timor leste' => 'TL',
            'timor-leste' => 'TL',
            'togo' => 'TG',
            'tonga' => 'TO',
            'trinidad and tobago' => 'TT',
            'tunisia' => 'TN',
            'turkey' => 'TR',
            'turkiye' => 'TR',
            'turkmenistan' => 'TM',
            'tuvalu' => 'TV',
            'uganda' => 'UG',
            'ukraine' => 'UA',
            'united arab emirates' => 'AE',
            'united kingdom' => 'GB',
            'united states' => 'US',
            'usa' => 'US',
            'america' => 'US',
            'amerika' => 'US',
            'uruguay' => 'UY',
            'uzbekistan' => 'UZ',
            'vanuatu' => 'VU',
            'venezuela' => 'VE',
            'vietnam' => 'VN',
            'yemen' => 'YE',
            'zambia' => 'ZM',
            'zimbabwe' => 'ZW',
        ];

        if (isset($countryMap[$countrySearch])) {
            $countrySearch = strtolower($countryMap[$countrySearch]);
        }

        $file = storage_path('app/ports.csv');

        if (file_exists($file)) {

            if (($handle = fopen($file, 'r')) !== false) {

                $header = fgetcsv($handle);

                while (($row = fgetcsv($handle)) !== false) {

                    $data = array_combine($header, $row);

                    $portName = $data['PORT_NAME'] ?? '';
                    $country = strtolower($data['COUNTRY'] ?? '');

                    if (
                        ($portSearch == '' || str_contains(strtolower($portName), $portSearch)) &&
                        ($countrySearch == '' || str_contains(strtolower($country), $countrySearch))
                    ) {

                        $ports[] = [
                            'port_name' => $portName,
                            'country' => $country,
                            'latitude' => $data['LATITUDE'],
                            'longitude' => $data['LONGITUDE'],
                        ];
                    }

                    if (count($ports) >= 100) {
                        break;
                    }
                }

                fclose($handle);
            }
        }

        $countryName = array_flip($countryMap);

        foreach ($ports as &$port) {

            $code = strtoupper($port['country']);

            if (isset($countryName[$code])) {
                $port['country'] = ucwords($countryName[$code]);
            } else {
                $port['country'] = $code;
            }
        }

        return view('ports.index', compact('ports'));
    }
}