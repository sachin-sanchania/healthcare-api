<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HealthcareProfessionalController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/professionals', [HealthcareProfessionalController::class, 'index'])->name('professionals.index');
    Route::group(['prefix' => 'appointment', 'name' => 'appointment', 'as' => 'appointment.'], static function () {
        Route::post('/view', [AppointmentController::class, 'view'])->name('view');
        Route::post('/book', [AppointmentController::class, 'book'])->name('book');
        Route::get('/cancel/{appointment}', [AppointmentController::class, 'cancel'])->name('cancel');
        Route::get('/complete/{appointment}', [AppointmentController::class, 'complete'])->name('complete');
    });
});
