<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SentimentController;

// Halaman utama

Route::get('/sentiment', [SentimentController::class, 'index'])
    ->name('sentiment.index');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/ports', [PortController::class, 'index'])->name('ports.index');
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

Route::get('/currency', [CurrencyController::class, 'index'])
    ->name('currency.index');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/countries', [CountryController::class, 'index'])
        ->name('countries.index');

    Route::post('/countries/sync', [CountryController::class, 'sync'])
        ->name('countries.sync');

    Route::post('/countries/sync-economics', [CountryController::class, 'syncEconomics'])
        ->name('countries.syncEconomics');

});
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/currency', [CurrencyController::class, 'check'])
    ->name('currency.check');

    Route::get('/test-worldbank', function () {

        $response = \Illuminate\Support\Facades\Http::withoutVerifying()
            ->get(
                'https://api.worldbank.org/v2/country/AF/indicator/NY.GDP.MKTP.CD',
                [
                    'format' => 'json',
                    'per_page' => 1,
                ]
            );

        dd(
            $response->status(),
            $response->body()
        );
    });


        Route::get('/test-worldbank', function () {

        $service = new \App\Services\WorldBankService();

        dd($service->getEconomicData('US'));

    });

    Route::middleware(['auth'])->group(function () {

    Route::get('/admin/dashboard',[AdminController::class,'dashboard'])
        ->name('admin.dashboard');

    });

    Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::resource('admin/users', \App\Http\Controllers\Admin\UserController::class)
        ->names('admin.users');
    });

});

require __DIR__.'/auth.php';