<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class CalendarController extends Controller
{
    // function index(Request $request, $view, $year, $month, $day)
    function index($view, $year, $month, $day)
    {
        $user = auth()->user();
        $date = CarbonImmutable::create($year, $month, $day);

        $holidaysJson = [];
        if (!$user || $user->settings->show_holidays) {
            // Usar Google Calendar API?
            $holidaysJson = Http::get("https://brasilapi.com.br/api/feriados/v1/$date->year")->json();
        }

        $holidays = collect($holidaysJson)
            ->map(
                fn ($item)
                => new Event(
                    [
                        'id' => -1,
                        'title' => $item['name'],
                        'start_date' => CarbonImmutable::parse($item['date']),
                        'end_date' => CarbonImmutable::parse($item['date'])->endOfDay(),
                    ]
                )
            );

        $period = CarbonPeriod::create($date->startOfYear(), $date->endOfYear());

        $events = $user ? $user->events->concat($user->eventsAsParticipant) : collect([]);
        $events->filter(
            fn ($event) => $period->overlaps($event->period)
        );

        $events = $events->concat($holidays)->sortBy('start_date');

        if (!in_array($view, ['year', 'month', 'week', 'day'])) {
            throw new RouteNotFoundException("Rota para a view '$view' não existe");
        }

        $searchQuery = Str::of(request()->query('search'))->lower();

        if (!$searchQuery->isEmpty()) {
            $events = $events->filter(
                fn ($event) => Str::of($event->title)->lower()->contains($searchQuery)
            );
        }

        return view($view, [
            'events' => $events,
            'date' => $date,
        ]);
    }
}
