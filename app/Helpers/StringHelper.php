<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * Convert Bengali digits to English digits.
     */
    public static function convertBengaliDigitsToEnglish(?string $value): ?string
    {
        if (! $value) {
            return $value;
        }

        $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($bn, $en, $value);
    }

    /**
     * Sanitize HTML by stripping dangerous tags while allowing safe formatting.
     */
    public static function sanitizeHtml(?string $html): ?string
    {
        if (! $html) {
            return $html;
        }

        $allowedTags = '<strong><em><b><i><u><span><a><code><br>';
        $html = strip_tags($html, $allowedTags);
        $html = preg_replace('/\s+on\w+\s*=\s*["\'][^"\']*["\']/i', '', $html);
        $html = preg_replace('/\s+on\w+\s*=\s*[^\s>]+/i', '', $html);

        return $html;
    }
}
