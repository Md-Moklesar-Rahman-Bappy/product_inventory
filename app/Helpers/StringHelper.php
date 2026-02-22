<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * Convert Bengali digits to English digits.
     *
     * @param string|null $value
     * @return string|null
     */
    public static function convertBengaliDigitsToEnglish(?string $value): ?string
    {
        if (!$value) {
            return $value;
        }

        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        $en = ['0','1','2','3','4','5','6','7','8','9'];

        return str_replace($bn, $en, $value);
    }
}
