<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    use App\Livewire\Vehicles\Index;

    Route::get('vehicles', Index::class)
        ->middleware(['auth', 'verified'])
        ->name('vehicles');
    

    Route::view('timesheets', 'timesheets')
    ->middleware(['auth', 'verified'])
    ->name('timesheets');

    Route::view('holidays', 'holidays')
    ->middleware(['auth', 'verified'])
    ->name('holidays');

    Route::view('van-logs', 'van-logs')
    ->middleware(['auth', 'verified'])
    ->name('van-logs');

    Route::view('mileage-logs', 'mileage-logs')
    ->middleware(['auth', 'verified'])
    ->name('mileage-logs');

    use App\Livewire\Vehicles\Show;

Route::get('/vehicles/{vehicle}', Show::class)->name('vehicles.show');

use App\Livewire\Vehicles\Create;

Route::get('/vehicles/create', Create::class)->name('vehicles.create');

use App\Livewire\Vehicles\Edit;

Route::get('/vehicles/{vehicle}/edit', Edit::class)->name('vehicles.edit');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
});


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
