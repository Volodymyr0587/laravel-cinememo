<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidReleaseDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Only allow YYYY, YYYY-MM, YYYY-MM-DD
        if (!preg_match('/^\d{4}(-\d{2}){0,2}$/', $value)) {
            $fail(__('validation.custom.release_date.format'));
            return;
        }

        $parts = explode('-', $value);

        $year = (int) $parts[0];
        $month = $parts[1] ?? null;
        $day   = $parts[2] ?? null;

        if ($year < 1800 || $year > 2100) {
            $fail(__('validation.custom.release_date.year_range'));
            return;
        }

        if ($month && ($month < 1 || $month > 12)) {
            $fail(__('validation.custom.release_date.invalid_month'));
            return;
        }

        if ($day !== null) {
            if ($month === null) {
                $fail(__('validation.custom.release_date.day_without_month'));
                return;
            }

            if (!checkdate($month, $day, $year)) {
                $fail(__('validation.custom.release_date.invalid_date'));
                return;
            }
        }
    }
}
