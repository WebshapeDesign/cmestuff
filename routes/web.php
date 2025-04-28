<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;

use App\Livewire\Vehicles\Index as VehiclesIndex;
use App\Livewire\Vehicles\Show as VehiclesShow;
use App\Livewire\Vehicles\Create as VehiclesCreate;
use App\Livewire\Vehicles\Edit as VehiclesEdit;

use App\Livewire\VanLogs\Index as VanLogsIndex;
use App\Livewire\VanLogs\Create as VanLogsCreate;

use App\Livewire\MileageLogs\Index as MileageLogsIndex;
use App\Livewire\MileageLogs\Create as MileageLogsCreate;
use App\Livewire\MileageLogs\Edit as MileageLogsEdit;

use App\Livewire\Timesheets\Index as TimesheetsIndex;
use App\Livewire\Timesheets\Create as TimesheetsCreate;
use App\Livewire\Timesheets\Edit as TimesheetsEdit;

// Home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Vehicles
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('vehicles', VehiclesIndex::class)->name('vehicles');
    Route::get('vehicles/create', VehiclesCreate::class)->name('vehicles.create');
    Route::get('vehicles/{vehicle}', VehiclesShow::class)->name('vehicles.show');
    Route::get('vehicles/{vehicle}/edit', VehiclesEdit::class)->name('vehicles.edit');
});

// Van Logs
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('van-logs', VanLogsIndex::class)->name('van-logs.index');
    Route::get('van-logs/create', VanLogsCreate::class)->name('van-logs.create');
});

// Mileage Logs
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('mileage-logs', MileageLogsIndex::class)->name('mileage-logs.index');
    Route::get('mileage-logs/create', MileageLogsCreate::class)->name('mileage-logs.create');
    Route::get('mileage-logs/{mileageLog}/edit', MileageLogsEdit::class)->name('mileage-logs.edit');
});

// Timesheets
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('timesheets', TimesheetsIndex::class)->name('timesheets.index');
    Route::get('timesheets/create', TimesheetsCreate::class)->name('timesheets.create');
    Route::get('timesheets/{timesheet}/edit', TimesheetsEdit::class)->name('timesheets.edit');
});

// Holidays
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('holidays', 'holidays')->name('holidays');
});

// Admin Only - Users
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::get('users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
});

// Settings
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Auth Routes
require __DIR__.'/auth.php';
