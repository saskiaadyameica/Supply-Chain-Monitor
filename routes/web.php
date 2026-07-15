<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', function () {

    // Jika sudah login → langsung ke dashboard
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    // Jika belum login → ke halaman login
    return redirect()->route('login');

})->name('home');


// Dashboard Admin
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth')->name('dashboard');


// Profile (sementara kita biarkan, nanti bisa kita hapus jika tidak dipakai)
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Countries
    Route::get('/countries', [App\Http\Controllers\CountryController::class, 'index'])
        ->name('countries.index');
});


// Authentication Route dari Breeze
require __DIR__.'/auth.php';