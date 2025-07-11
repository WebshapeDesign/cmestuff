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
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\MileageLogController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\HolidayController;

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
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

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
    Route::get('/settings/profile', [SettingsController::class, 'profile'])->name('settings.profile');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::put('/settings/preferences', [SettingsController::class, 'updatePreferences'])->name('settings.preferences.update');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Vehicle routes
    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::patch('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');

    // Mileage Log routes
    Route::get('/mileage-logs', [MileageLogController::class, 'index'])->name('mileage-logs.index');
    Route::get('/mileage-logs/create', [MileageLogController::class, 'create'])->name('mileage-logs.create');
    Route::post('/mileage-logs', [MileageLogController::class, 'store'])->name('mileage-logs.store');
    Route::get('/mileage-logs/{mileageLog}', [MileageLogController::class, 'show'])->name('mileage-logs.show');
    Route::get('/mileage-logs/{mileageLog}/edit', [MileageLogController::class, 'edit'])->name('mileage-logs.edit');
    Route::patch('/mileage-logs/{mileageLog}', [MileageLogController::class, 'update'])->name('mileage-logs.update');
    Route::delete('/mileage-logs/{mileageLog}', [MileageLogController::class, 'destroy'])->name('mileage-logs.destroy');

    // Holiday routes
    Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays.index');
    Route::get('/holidays/create', [HolidayController::class, 'create'])->name('holidays.create');
    Route::post('/holidays', [HolidayController::class, 'store'])->name('holidays.store');
    Route::get('/holidays/{holiday}', [HolidayController::class, 'show'])->name('holidays.show');
    Route::get('/holidays/{holiday}/edit', [HolidayController::class, 'edit'])->name('holidays.edit');
    Route::patch('/holidays/{holiday}', [HolidayController::class, 'update'])->name('holidays.update');
    Route::delete('/holidays/{holiday}', [HolidayController::class, 'destroy'])->name('holidays.destroy');

    // User routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Authenticated & Verified Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Van Logs
    Route::get('van-logs', [VanLogController::class, 'index'])->name('van-logs.index');
    Route::get('van-logs/create', [VanLogController::class, 'create'])->name('van-logs.create');
    Route::get('van-logs/{vanLog}', [VanLogController::class, 'show'])->name('van-logs.show');
    Route::get('van-logs/{vanLog}/edit', [VanLogController::class, 'edit'])->name('van-logs.edit');
    Route::post('van-logs', [VanLogController::class, 'store'])->name('van-logs.store');
    Route::put('van-logs/{vanLog}', [VanLogController::class, 'update'])->name('van-logs.update');

    // Timesheets
    Route::get('timesheets', [TimesheetController::class, 'index'])->name('timesheets.index');
    Route::get('timesheets/create', [TimesheetController::class, 'create'])->name('timesheets.create');
    Route::get('timesheets/{timesheet}/edit', [TimesheetController::class, 'edit'])->name('timesheets.edit');
    Route::post('timesheets', [TimesheetController::class, 'store'])->name('timesheets.store');
    Route::put('timesheets/{timesheet}', [TimesheetController::class, 'update'])->name('timesheets.update');

    // Holidays
    Route::get('holidays', [HolidayRequestController::class, 'index'])->name('holidays.index');
    Route::get('holidays/create', [HolidayRequestController::class, 'create'])->name('holidays.create');
    Route::post('holidays', [HolidayRequestController::class, 'store'])->name('holidays.store');
    Route::get('holidays/{holidayRequest}', [HolidayRequestController::class, 'show'])->name('holidays.show');
    Route::get('holidays/{holidayRequest}/edit', [HolidayRequestController::class, 'edit'])->name('holidays.edit');
    Route::put('holidays/{holidayRequest}', [HolidayRequestController::class, 'update'])->name('holidays.update');
    Route::delete('holidays/{holidayRequest}', [HolidayRequestController::class, 'destroy'])->name('holidays.destroy');
    Route::post('holidays/{holidayRequest}/approve', [HolidayRequestController::class, 'approve'])->name('holidays.approve');
    Route::post('holidays/{holidayRequest}/reject', [HolidayRequestController::class, 'reject'])->name('holidays.reject');
});

// Admin-only Routes
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Auth
require __DIR__.'/auth.php';
