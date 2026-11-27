<?php

namespace App\Support;

use Carbon\Carbon;

class Format
{
    public static function date(mixed $value): string
    {
        return Carbon::parse($value)->format('j F Y');
    }

    public static function money(int $amount): string
    {
        return '$'.number_format($amount, 0);
    }

    public static function when(mixed $value): string
    {
        return Carbon::parse($value)->timezone(config('app.timezone'))->format('j M Y, H:i');
    }
}
