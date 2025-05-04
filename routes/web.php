<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VanLogController;
use App\Http\Controllers\HolidayRequestController;
use App\Http\Controllers\DashboardController;

// Vehicles
use App\Livewire\Vehicles\Index as VehiclesIndex;
use App\Livewire\Vehicles\Create as VehiclesCreate;
use App\Livewire\Vehicles\Edit as VehiclesEdit;
use App\Livewire\Vehicles\Show as VehiclesShow;

// Van Logs
use App\Livewire\VanLogs\Index as VanLogsIndex;
use App\Livewire\VanLogs\Create as VanLogsCreate;

// Mileage Logs
use App\Livewire\MileageLogs\Index as MileageLogsIndex;
use App\Livewire\MileageLogs\Create as MileageLogsCreate;
use App\Livewire\MileageLogs\Edit as MileageLogsEdit;

// Timesheets
use App\Livewire\Timesheets\Index as TimesheetsIndex;
use App\Livewire\Timesheets\Create as TimesheetsCreate;
use App\Livewire\Timesheets\Edit as TimesheetsEdit;

// Dashboard & Home
Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Settings
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Authenticated & Verified Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Vehicles
    Route::get('vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::get('vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::get('vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');

    // Van Logs
    Route::get('van-logs', [VanLogController::class, 'index'])->name('van-logs.index');
    Route::get('van-logs/create', [VanLogController::class, 'create'])->name('van-logs.create');

    // Mileage Logs
    Route::get('mileage-logs', [MileageLogController::class, 'index'])->name('mileage-logs.index');
    Route::get('mileage-logs/create', [MileageLogController::class, 'create'])->name('mileage-logs.create');
    Route::get('mileage-logs/{mileageLog}/edit', [MileageLogController::class, 'edit'])->name('mileage-logs.edit');

    // Timesheets
    Route::get('timesheets', [TimesheetController::class, 'index'])->name('timesheets.index');
    Route::get('timesheets/create', [TimesheetController::class, 'create'])->name('timesheets.create');
    Route::get('timesheets/{timesheet}/edit', [TimesheetController::class, 'edit'])->name('timesheets.edit');

    // Holidays
    Route::get('holidays', [HolidayRequestController::class, 'index'])->name('holidays.index');
});

// Admin-only Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
});

// Auth
require __DIR__.'/auth.php';
