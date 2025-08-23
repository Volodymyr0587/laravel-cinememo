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
            $fail(__('validation.custom.release_date'));
            return;
        }

        $parts = explode('-', $value);

        $year = (int) $parts[0];
        $month = $parts[1] ?? null;
        $day   = $parts[2] ?? null;

        if ($year < 1800 || $year > 2100) {
            $fail('The :attribute year must be between 1800 and 2100.');
            return;
        }

        if ($month && ($month < 1 || $month > 12)) {
            $fail(__('validation.custom.release_date'));
            return;
        }

        if ($day !== null) {
            if ($month === null) {
                $fail('The :attribute cannot have a day without a month.');
                return;
            }

            if (!checkdate($month, $day, $year)) {
                $fail('The :attribute is not a valid date.');
                return;
            }
        }
    }
}
