<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () { // V1

    // GRUPO DE RUTAS PARA API V1 DE AUTENTICACIÓN
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login'); // INICIO DE SESIÓN

    Route::group(['middleware' => 'jwt.verify', 'prefix' => 'auth'], function ($router) {
        Route::post('/profile', [AuthController::class, 'profile'])->name('profile'); // PERFIL DEL USUARIO
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // CIERRE DE SESIÓN
    });

    // GRUPO DE RUTAS PARA HORARIOS
    Route::group(['middleware' => 'jwt.verify', 'prefix' => 'schedules'], function ($router) {
        Route::get('/getSchedules', [ScheduleController::class, 'getSchedules'])->name('schedules.getSchedules'); // LISTAR HORARIOS
        Route::post('/store', [ScheduleController::class, 'store'])->name('schedules.store'); // CREACIÓN DE HORARIOS
        Route::get('/{schedule}/show', [ScheduleController::class, 'show'])->name('schedules.show'); // DETALLE DEL HORARIO
        Route::put('/{schedule}/update', [ScheduleController::class, 'update'])->name('schedules.update'); // ACTUALIZACIÓN DEL HORARIO
        Route::delete('/{schedule}/destroy', [ScheduleController::class, 'destroy'])->name('schedules.destroy'); // ELIMINACIÓN DEL HORARIO
    });

    // GRUPO DE RUTAS PARA LECCIONES
    Route::group(['middleware' => 'jwt.verify', 'prefix' => 'lessons'], function ($router) {
        Route::get('/getLessons', [LessonController::class, 'getLessons'])->name('lessons.getLessons'); // LISTAR LECCIONES
        Route::post('/store', [LessonController::class, 'store'])->name('lessons.store'); // CREACIÓN DE LECCIONES
        Route::get('/{lesson}/show', [LessonController::class, 'show'])->name('lessons.show'); // DETALLE DE LA LECCIÓN
        Route::put('/{lesson}/update', [LessonController::class, 'update'])->name('lessons.update'); // ACTUALIZACIÓN DE LA LECCIÓN
        Route::delete('/{lesson}/destroy', [LessonController::class, 'destroy'])->name('lessons.destroy'); // ELIMINACIÓN DE LA LECCIÓN
    });

    // GRUPO DE RUTAS PARA REGISTRO DE RESERVA DE LECCIONES
    Route::group(['middleware' => 'jwt.verify', 'prefix' => 'reservations'], function ($router) {
        Route::get('/getReservations', [ReservationController::class, 'getReservations'])->name('reservations.getReservations'); // LISTAR RESERVAS
        Route::post('/store', [ReservationController::class, 'store'])->name('reservations.store'); // CREACIÓN DE RESERVAS
        Route::get('/{reservation}/show', [ReservationController::class, 'show'])->name('reservations.show'); // DETALLE DE LA RESERVA
        Route::put('/{reservation}/update', [ReservationController::class, 'update'])->name('reservations.update'); // ACTUALIZACIÓN DE LA RESERVA
        Route::delete('/{reservation}/destroy', [ReservationController::class, 'destroy'])->name('reservations.destroy'); // ELIMINACIÓN DE LA RESERVA
    });
});
