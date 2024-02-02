<?php

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
            'date' => strtotime('2024-02-21'),
            'isHoliday' => false
        ],
        [
            'title' => 'Carnaval 2024',
            'date' => strtotime('2024-02-09'),
            'isHoliday' => true
        ],
        [
            'title' => 'Quarta-feira de cinzas',
            'date' => strtotime('2024-02-14'),
            'isHoliday' => true
        ],
        [
            'title' => 'dhsadgdsgadgs',
            'date' => strtotime('2024-02-14'),
            'isHoliday' => false
        ],
        [
            'title' => 'Dia de pagamento',
            'date' => strtotime('2024-02-29'),
            'isHoliday' => false
        ],
        [
            'title' => 'Meu niver',
            'date' => strtotime('2024-03-21'),
            'isHoliday' => false
        ],
        [
            'title' => 'Natal',
            'date' => strtotime('2024-12-25'),
            'isHoliday' => true
        ],
    ];
    // Ordernar por data ascendente
    usort($events, function ($a, $b) {
        return $a['date'] - $b['date'];
    });

    return $events;
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
});

Route::get('/month/{year}/{month}/{day}', function ($year, $month, $day) {
    $date = CarbonImmutable::create($year, $month, $day);
    return view('month', [
        'events' => getEvents(),
        'date' => $date,
        'pageTitle' => $date->translatedFormat('F \\d\\e Y'),
        'navTitle' => ucfirst($date->translatedFormat('F \\d\\e Y')),
        'view' => 'month',
        'today' => CarbonImmutable::today()
    ]);
});

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
});
