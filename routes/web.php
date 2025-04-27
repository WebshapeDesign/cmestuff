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

    Route::view('users', 'users')
    ->middleware(['auth', 'verified'])
    ->name('users');

    use App\Models\Vehicle;

    Route::get('vehicles', function () {
        return view('vehicles', [
            'vehicles' => Vehicle::all(),
        ]);
    })->middleware(['auth', 'verified'])->name('vehicles');
    

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

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
