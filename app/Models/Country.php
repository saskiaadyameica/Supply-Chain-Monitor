<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'capital',
        'region',
        'population',
        'currency',
        'currency_code',
        'currency_symbol',
        'language',
        'flag',
        'latitude',
        'longitude',
    ];

    public function economics(): HasOne
    {
        return $this->hasOne(CountryEconomic::class, 'country_id');
    }
}