<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
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
    if (session()->has('success')) {
        session()->flash('success', session('success'));
    }

    return redirect('/month/' . CarbonImmutable::today()->format('Y/n/j'));
});

// TODO: Filtrar por data
// function getEvents($from, $to)
function getEvents(int $year)
{
    // Usar Google Calendar API?
    $holidaysJson = Http::get("https://brasilapi.com.br/api/feriados/v1/$year")->json();
    // $holidaysJson = [];

    $holidays = collect($holidaysJson)->map(fn ($item) => new Event(
        [
            'id' => -1,
            'title' => $item['name'],
            'start_date' => CarbonImmutable::parse($item['date']),
            'end_date' => CarbonImmutable::parse($item['date'])->endOfDay(),
        ]
    ));

    $events = auth()->user() ? auth()->user()->events : collect([]);

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

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->middleware('guest');
Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::get('/settings', [UserController::class, 'edit'])->middleware('auth');
Route::patch('/settings', [UserController::class, 'update'])->middleware('auth');

Route::resource('users.events', EventController::class)->shallow()->middleware(['auth', 'can:creator']);
