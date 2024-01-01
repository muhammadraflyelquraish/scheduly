<?php

use App\Http\Controllers\ClassesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MatkulController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleDetailController;
use App\Http\Controllers\ScheduleMatkulClassController;
use App\Http\Controllers\ScheduleMatkulController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/schedule/download', [ScheduleController::class, 'downloadPDF'])->name('schedule.download');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'data'])->name('dashboard.data');

    Route::resource('/class', ClassesController::class);
    Route::resource('/matkul', MatkulController::class);
    Route::get('/schedule/data', [ScheduleController::class, 'data'])->name('schedule.data');
    Route::get('/order/export', [ScheduleController::class, 'export'])->name('schedule.export');
    Route::resource('/schedule', ScheduleController::class);
    Route::resource('/schedule-detail', ScheduleDetailController::class);
    Route::resource('/schedule-matkul', ScheduleMatkulController::class);
    Route::resource('/schedule-matkul-class', ScheduleMatkulClassController::class);
    Route::resource('/user', UserController::class);
});


require __DIR__ . '/auth.php';
