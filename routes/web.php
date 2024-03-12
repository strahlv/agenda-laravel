<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use App\Models\Event;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Http;
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

Route::get('/{view}/{year}/{month}/{day}', [CalendarController::class, 'index'])->whereNumber(['year', 'month', 'day']);

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
