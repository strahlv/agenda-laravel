<?php

namespace App;

use Carbon\CarbonImmutable;

class Helpers
{
    public static function formatToCalendarUrl(string $view, CarbonImmutable $dt, string $display = null): string
    {
        return '/' . $view . '/' . $dt->format('Y/n/j') . ($display ? '?display=' . $display : null);
    }
}
