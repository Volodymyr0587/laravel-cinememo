<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function formatReleaseDate(string $value, ?string $locale = null): string
    {
        if (preg_match('/^\d{4}$/', $value)) {
            return $value;
        }

        if (preg_match('/^\d{4}-\d{2}$/', $value)) {
            return Carbon::createFromFormat('Y-m', $value)
                ->locale($locale ?? app()->getLocale())
                ->isoFormat('YYYY MMMM');
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return Carbon::createFromFormat('Y-m-d', $value)
                ->locale($locale ?? app()->getLocale())
                ->isoFormat('LL');
        }

        return $value;
    }
}
