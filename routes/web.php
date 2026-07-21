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
use App\Http\Controllers\SentimentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DatasetController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');

})->name('home');

Route::get('/news', [NewsController::class, 'index'])
    ->name('news.index');

Route::get('/ports', [PortController::class, 'index'])
    ->name('ports.index');

Route::get('/weather', [WeatherController::class, 'index'])
    ->name('weather.index');

Route::post('/weather', [WeatherController::class, 'check'])
    ->name('weather.check');

Route::get('/currency', [CurrencyController::class, 'index'])
    ->name('currency.index');

Route::get('/sentiment', [SentimentController::class, 'index'])
    ->name('sentiment.index');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Countries
    |--------------------------------------------------------------------------
    */

    Route::get('/countries', [CountryController::class, 'index'])
        ->name('countries.index');

    Route::post('/countries/sync', [CountryController::class, 'sync'])
        ->name('countries.sync');

    Route::post('/countries/sync-economics', [CountryController::class, 'syncEconomics'])
        ->name('countries.syncEconomics');

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */

    Route::post('/currency', [CurrencyController::class, 'check'])
        ->name('currency.check');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class)
            ->names('admin.articles');

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        Route::resource('users', UserController::class)
            ->names('admin.users');

        /*
        |--------------------------------------------------------------------------
        | Port Dataset
        |--------------------------------------------------------------------------
        */

        Route::get('/dataset', [DatasetController::class, 'index'])
            ->name('admin.dataset.index');

        Route::get('/dataset/create', [DatasetController::class, 'create'])
            ->name('admin.dataset.create');

        Route::post('/dataset', [DatasetController::class, 'store'])
            ->name('admin.dataset.store');

        Route::get('/dataset/{id}/edit', [DatasetController::class, 'edit'])
            ->name('admin.dataset.edit');

        Route::put('/dataset/{id}', [DatasetController::class, 'update'])
            ->name('admin.dataset.update');

        Route::delete('/dataset/{id}', [DatasetController::class, 'destroy'])
            ->name('admin.dataset.destroy');
        Route::post('/dataset/upload', [DatasetController::class,'upload'])
            ->name('admin.dataset.upload');

    });

});

/*
|--------------------------------------------------------------------------
| Auth Scaffolding
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';