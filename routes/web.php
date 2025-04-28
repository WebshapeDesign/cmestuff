<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

use App\Livewire\Vehicles\Index;
use App\Livewire\Vehicles\Show;
use App\Livewire\Vehicles\Create;
use App\Livewire\Vehicles\Edit;
use App\Livewire\VanLogs\Index as VanLogsIndex;
use App\Livewire\VanLogs\Create as VanLogsCreate;
use App\Livewire\MileageLogs\Index as MileageLogsIndex;
use App\Livewire\MileageLogs\Create as MileageLogsCreate;
use App\Livewire\MileageLogs\Edit as MileageLogsEdit;

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
    Route::get('vehicles', Index::class)->name('vehicles');
    Route::get('vehicles/create', Create::class)->name('vehicles.create');
    Route::get('vehicles/{vehicle}', Show::class)->name('vehicles.show');
    Route::get('vehicles/{vehicle}/edit', Edit::class)->name('vehicles.edit');
});

// Timesheets and Holidays
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('timesheets', TimesheetsIndex::class)->name('timesheets.index');
    Route::get('timesheets/create', TimesheetsCreate::class)->name('timesheets.create');
    Route::get('timesheets/{timesheet}/edit', TimesheetsEdit::class)->name('timesheets.edit');
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

// Admin Only - Users
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
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
