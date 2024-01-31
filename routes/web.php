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
    return view('welcome', []);
});

Route::get('/year/{year}/{month}/{day}', function ($year, $month, $day) {
    $date = CarbonImmutable::create($year, $month, $day);
    return view('welcome', [
        'date' => $date,
        'pageTitle' => 'Ano ' . $year,
        'navTitle' => $year,
        'view' => 'year',
        'today' => CarbonImmutable::today()
    ]);
});

Route::get('/month/{year}/{month}/{day}', function ($year, $month, $day) {
    $date = CarbonImmutable::create($year, $month, $day);
    return view('welcome', [
        'date' => $date,
        'pageTitle' => $date->translatedFormat('F \\d\\e Y'),
        'navTitle' => ucfirst($date->translatedFormat('F \\d\\e Y')),
        'view' => 'month',
        'today' => CarbonImmutable::today()
    ]);
});

Route::get('/day/{year}/{month}/{day}', function ($year, $month, $day) {
    $date = CarbonImmutable::create($year, $month, $day);
    return view('welcome', [
        'date' => $date,
        'pageTitle' => $date->translatedFormat('l, j \\d\\e F \\d\\e Y'),
        'navTitle' => $date->translatedFormat('j \\d\\e F \\d\\e Y'),
        'view' => 'day',
        'today' => CarbonImmutable::today()
    ]);
});
