<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\DoctorController;

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
Route::get('clear', function() {
    $currentDate = new Carbon;
    Artisan::call('cache:clear');
    Artisan::call('optimize:clear');
    return "Se limpió: route, config, cache y view en " . $currentDate;
});

// Rutas para el controlador de categorías
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']); // Listar todas las categorías
    Route::get('/bydoctor/{id}', [CategoryController::class, 'indexDoctor']); // Listar todos los doctores por categoría
    Route::post('/', [CategoryController::class, 'store']); // Crear una nueva categoría
    Route::post('/{id}', [CategoryController::class, 'update']); // Actualizar una categoría
    Route::delete('/{id}', [CategoryController::class, 'destroy']); // Eliminar suave una categoría
});

// Rutas para el controlador de hospital
Route::prefix('hospital')->group(function () {
    Route::get('/', [HospitalController::class, 'index']); // Listar todas las hospital
    Route::post('/', [HospitalController::class, 'store']); // Crear una nueva hospital
    Route::put('/{id}', [HospitalController::class, 'update']); // Actualizar una hospital
    Route::delete('/{id}', [HospitalController::class, 'destroy']); // Eliminar suave una hospital
});

// Rutas para el controlador de doctor
Route::prefix('doctor')->group(function () {
    Route::get('/', [DoctorController::class, 'index']); // Listar todas las doctor
    Route::get('/data/{id}', [DoctorController::class, 'indexDoctor']); // Listar los datos de un doctor
    Route::post('/', [DoctorController::class, 'store']); // Crear una nueva doctor
    Route::post('/{id}', [DoctorController::class, 'update']); // Actualizar una doctor
    Route::delete('/{id}', [DoctorController::class, 'destroy']); // Eliminar suave una doctor
});

