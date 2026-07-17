<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}