<?php

use App\Models\Event;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

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

Route::get('/{view}/{year}/{month}/{day}', function ($view, $year, $month, $day) {
    if (!in_array($view, ['year', 'month', 'day'])) {
        throw new RouteNotFoundException("Rota '$view' não existe");
    }

    $date = CarbonImmutable::create($year, $month, $day);
    return view($view, [
        'events' => getEvents(),
        'date' => $date,
    ]);
})->whereNumber(['year', 'month', 'day']);
