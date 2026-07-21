<?php

namespace App\Helpers;

class NumberHelper
{
    public static function money($number)
    {
        if ($number === null) {
            return '-';
        }

        if ($number >= 1000000000000) {
            return 'US$' . number_format($number / 1000000000000, 2) . ' T';
        }

        if ($number >= 1000000000) {
            return 'US$' . number_format($number / 1000000000, 2) . ' B';
        }

        if ($number >= 1000000) {
            return 'US$' . number_format($number / 1000000, 2) . ' M';
        }

        return 'US$' . number_format($number, 2);
    }
}