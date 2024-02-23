<?php

namespace App;

use App\Models\Event;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class Helpers
{
    public static function formatToCalendarUrl(string $view, Carbon|CarbonImmutable $dt, string $display = null): string
    {
        return '/' . $view . '/' . $dt->format('Y/n/j') . ($display ? '?display=' . $display : null);
    }
}
