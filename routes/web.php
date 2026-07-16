<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WeatherController;

// Halaman utama
Route::get('/weather', [WeatherController::class, 'index'])
    ->name('weather.index');
Route::post('/weather', [WeatherController::class, 'check'])
    ->name('weather.check');
Route::get('/', function () {

    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');

})->name('home');


// Dashboard Admin
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/countries', [CountryController::class, 'index'])
        ->name('countries.index');

    Route::post('/countries/sync', [CountryController::class, 'sync'])
        ->name('countries.sync');

});
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Countries
    Route::get('/countries', [App\Http\Controllers\CountryController::class, 'index'])
        ->name('countries.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');    
});

require __DIR__.'/auth.php';