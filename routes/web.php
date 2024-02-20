<?php

use App\Http\Controllers\EventController;
use App\Models\Event;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Http;
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

function getEvents(int $year)
{
    $holidaysJson = [];
    // USAR GOOGLE CALENDAR API?
    // $holidaysJson = Http::get("https://brasilapi.com.br/api/feriados/v1/$year")->json();
    $holidays = collect($holidaysJson)->map(fn ($item) => new Event(
        [
            'title' => $item['name'],
            'date' => CarbonImmutable::parse($item['date']),
        ]
    ));

    $events = User::find(1)->events;

    return $events->concat($holidays)->sortBy('start_date');
}

Route::get('/{view}/{year}/{month}/{day}', function ($view, $year, $month, $day) {
    if (!in_array($view, ['year', 'month', 'week', 'day'])) {
        throw new RouteNotFoundException("Rota para a view '$view' não existe");
    }

    $date = CarbonImmutable::create($year, $month, $day);

    return view($view, [
        'events' => getEvents($year),
        'date' => $date,
    ]);
})->whereNumber(['year', 'month', 'day']);

Route::resource('users.events', EventController::class)->shallow();
