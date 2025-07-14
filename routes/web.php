<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ConcertController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [ConcertController::class, 'index'])->name('concerts.index');
Route::get('/concerts/{id}', [ConcertController::class, 'show'])->name('concerts.show');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (register/login/logout)
|--------------------------------------------------------------------------
*/

Route::get('/register', [UserController::class, 'create'])
    ->name('users.register')
    ->middleware('guest');

Route::post('/users', [UserController::class, 'store'])
    ->name('users.store');

Route::get('/login', [UserController::class, 'login'])
    ->name('login')
    ->middleware('guest');

Route::post('/users/authenticate', [UserController::class, 'authenticate'])
    ->name('users.authenticate');

Route::post('/logout', [UserController::class, 'logout'])
    ->name('users.logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| USER ROUTES (auth required)
|--------------------------------------------------------------------------
*/

// Reservations
Route::middleware('auth')->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::get('/reservations/history', [ReservationController::class, 'history'])->name('reservations.history');

    // Favorites
    Route::post('/favorites/{concert}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

    // Ratings
    Route::post('/concerts/{concert}/rate', [RatingController::class, 'store'])->name('ratings.store');
    Route::get('/ratings/{rating}/edit', [RatingController::class, 'edit'])->name('ratings.edit');
    Route::put('/ratings/{rating}', [RatingController::class, 'update'])->name('ratings.update');
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');

    // Locations CRUD (auth user)
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create');
    Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
    Route::get('/locations/{location}', [LocationController::class, 'show'])->name('locations.show');
    Route::get('/locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
    Route::put('/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'is_admin'])->group(function () {

    // Concerts
    Route::get('/create', [ConcertController::class, 'create'])->name('concerts.create');
    Route::post('/concerts', [ConcertController::class, 'store'])->name('concerts.store');
    Route::get('/concerts/{concert}/edit', [ConcertController::class, 'edit'])->name('concerts.edit');
    Route::put('/concerts/{concert}', [ConcertController::class, 'update'])->name('concerts.update');
    Route::delete('/concerts/{concert}', [ConcertController::class, 'destroy'])->name('concerts.destroy');
    Route::get('/manage', [ConcertController::class, 'manage'])->name('concerts.manage');

    // Artists
    Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
    Route::get('/artists/create', [ArtistController::class, 'create'])->name('artists.create');
    Route::post('/artists', [ArtistController::class, 'store'])->name('artists.store');
    Route::get('/artists/{artist}/edit', [ArtistController::class, 'edit'])->name('artists.edit');
    Route::put('/artists/{artist}', [ArtistController::class, 'update'])->name('artists.update');
    Route::delete('/artists/{artist}', [ArtistController::class, 'destroy'])->name('artists.destroy');
});
