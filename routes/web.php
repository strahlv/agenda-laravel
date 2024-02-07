<?php

use App\Http\Controllers\EventController;
use App\Models\Event;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

use function PHPSTORM_META\map;

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

function getEvents(int $year)
{
    $holidays = [];
    // USAR GOOGLE CALENDAR API?
    // $holidays = json_decode(file_get_contents("https://brasilapi.com.br/api/feriados/v1/$year"));
    $json = Http::get(route("users.events.index", ['user' => 1]))->json();
    $userEvents = collect($json)->map(fn ($item) => new Event([
        'title' => $item['title'],
        'date' => $item['date'],
    ]));

    return collect($holidays)
        ->map(fn ($item) => new Event(
            [
                'title' => $item->name,
                'date' => CarbonImmutable::parse($item->date),
            ]
        ))
        ->merge($userEvents)
        ->sortBy('date');
}

Route::get('/{view}/{year}/{month}/{day}', function ($view, $year, $month, $day) {
    if (!in_array($view, ['year', 'month', 'day'])) {
        throw new RouteNotFoundException("Rota para a view '$view' não existe");
    }

    $date = CarbonImmutable::create($year, $month, $day);
    return view($view, [
        'events' => getEvents($year),
        'date' => $date,
    ]);
})->whereNumber(['year', 'month', 'day']);
