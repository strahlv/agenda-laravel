<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use App\Mail\TestMail;
use App\Models\Event;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
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

function getEvents(CarbonImmutable $date)
{
    $user = auth()->user();

    $holidaysJson = [];
    if (!$user || $user->settings->show_holidays) {
        // Usar Google Calendar API?
        $holidaysJson = Http::get("https://brasilapi.com.br/api/feriados/v1/$date->year")->json();
    }

    $holidays = collect($holidaysJson)->map(fn ($item) => new Event(
        [
            'id' => -1,
            'title' => $item['name'],
            'start_date' => CarbonImmutable::parse($item['date']),
            'end_date' => CarbonImmutable::parse($item['date'])->endOfDay(),
        ]
    ));

    $period = CarbonPeriod::create($date->startOfYear(), $date->endOfYear());

    $events = $user ? $user->events->concat($user->eventsAsParticipant) : collect([]);
    $events->filter(
        fn ($event) =>
        $period->overlaps($event->period)
    );

    return $events->concat($holidays)->sortBy('start_date');
}

// TODO: CalendarController?
Route::get('/{view}/{year}/{month}/{day}', function ($view, $year, $month, $day) {
    if (!in_array($view, ['year', 'month', 'week', 'day'])) {
        throw new RouteNotFoundException("Rota para a view '$view' não existe");
    }

    $date = CarbonImmutable::create($year, $month, $day);
    $searchQuery = Str::of(request()->query('search'))->lower();

    $events = getEvents($date);

    if (!$searchQuery->isEmpty()) {
        $events = $events->filter(
            fn ($event) => Str::of($event->title)->lower()->contains($searchQuery)
        );
    }

    return view($view, [
        'events' => $events,
        'date' => $date,
    ]);
})->whereNumber(['year', 'month', 'day']);

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->middleware('guest');
Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::get('/users', [UserController::class, 'index'])->middleware('auth');
Route::get('/settings', [UserController::class, 'edit'])->middleware('auth');
Route::patch('/user', [UserController::class, 'update'])->middleware('auth');

Route::patch('/settings', [UserSettingController::class, 'update'])->middleware('auth');

Route::resource('users.events', EventController::class)->shallow()->middleware('auth');
