<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPartialDate implements ValidationRule
{
    public function __construct(
        private int $minYear = 1800,
        private int $maxYear = 2100,
    ) {}
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\d{4}(-\d{2}){0,2}$/', $value)) {
            $fail(__('validation.custom.partial_date.format'));
            return;
        }

        $parts = explode('-', $value);
        $year  = (int) $parts[0];
        $month = $parts[1] ?? null;
        $day   = $parts[2] ?? null;

        if ($year < $this->minYear || $year > $this->maxYear) {
            $fail(__('validation.custom.partial_date.year_range', [
                'min' => $this->minYear,
                'max' => $this->maxYear,
            ]));
            return;
        }

        if ($month && ($month < 1 || $month > 12)) {
            $fail(__('validation.custom.partial_date.invalid_month'));
            return;
        }

        if ($day !== null) {
            if ($month === null) {
                $fail(__('validation.custom.partial_date.day_without_month'));
                return;
            }

            if (!checkdate((int) $month, (int) $day, $year)) {
                $fail(__('validation.custom.partial_date.invalid_date'));
                return;
            }
        }
    }
}
