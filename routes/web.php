<?php

use App\Models\Event;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/month/' . CarbonImmutable::today()->format('Y/n/j'));
    return view('welcome', []);
});

function getEvents()
{
    $events = [
        [
            'title' => 'Aniversário de Fulano',
            'date' => CarbonImmutable::create(2024, 2, 21),
        ],
        [
            'title' => 'Carnaval 2024',
            'date' => CarbonImmutable::create(2024, 2, 9),
        ],
        [
            'title' => 'Quarta-feira de cinzas',
            'date' => CarbonImmutable::create(2024, 2, 14),
        ],
        [
            'title' => 'gfgfewrew Teste',
            'date' => CarbonImmutable::create(2024, 2, 14),
        ],
        [
            'title' => 'Dia de pagamento',
            'date' => CarbonImmutable::create(2024, 2, 29),
        ],
        [
            'title' => 'Meu niver',
            'date' => CarbonImmutable::create(2024, 3, 21),
        ],
        [
            'title' => 'Natal',
            'date' => CarbonImmutable::create(2024, 12, 25),
        ],
    ];

    $userEvents = Event::all();

    return collect($events)
        ->map(fn ($item) => new Event(['title' => $item['title'], 'date' => $item['date']]))
        ->merge($userEvents)
        ->sortBy('date');
    // ->toArray();
}

Route::get('/year/{year}/{month}/{day}', function ($year, $month, $day) {
    $date = CarbonImmutable::create($year, $month, $day);
    return view('year', [
        'events' => getEvents(),
        'date' => $date,
        'pageTitle' => 'Ano ' . $year,
        'navTitle' => $year,
        'view' => 'year',
        'today' => CarbonImmutable::today()
    ]);
})->whereNumber(['year', 'month', 'day']);

Route::get('/month/{year}/{month}/{day}', function ($year, $month, $day) {
    $date = CarbonImmutable::create($year, $month, $day);
    // ddd(getEvents());
    return view('month', [
        'events' => getEvents(),
        'date' => $date,
        'pageTitle' => $date->translatedFormat('F \\d\\e Y'),
        'navTitle' => ucfirst($date->translatedFormat('F \\d\\e Y')),
        'view' => 'month',
        'today' => CarbonImmutable::today()
    ]);
})->whereNumber(['year', 'month', 'day']);

Route::get('/day/{year}/{month}/{day}', function ($year, $month, $day) {
    $date = CarbonImmutable::create($year, $month, $day);
    return view('day', [
        'events' => getEvents(),
        'date' => $date,
        'pageTitle' => $date->translatedFormat('l, j \\d\\e F \\d\\e Y'),
        'navTitle' => $date->translatedFormat('j \\d\\e F \\d\\e Y'),
        'view' => 'day',
        'today' => CarbonImmutable::today()
    ]);
})->whereNumber(['year', 'month', 'day']);
