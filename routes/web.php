<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

# Public Routes

// Landing Page
Route::get('/', [\App\Http\Controllers\LandingController::class, 'index'])->name('landing');


// Peta WebGIS
Route::get('/peta', [PetaController::class, 'index'])
    ->name('peta.index');

// Data & Insight
Route::get('/data', [DataController::class, 'index'])
    ->name('data.index');


# Authentication Routes

// Login Page
Route::get('/login', [LoginController::class, 'showLogin'])
    ->name('login');

// Login Process
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.process');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


# Admin Routes (Protected)

Route::middleware('auth')->prefix('admin')->group(function () {

    // Dashboard Admin
    Route::get('/pageadmin', [AdminController::class, 'index'])
        ->name('admin.page');

    // CRUD Kawasan Industri
    Route::post('/kawasan', [AdminController::class, 'storeKawasan'])
        ->name('admin.kawasan.store');

    Route::put('/kawasan/{id}', [AdminController::class, 'updateKawasan'])
        ->name('admin.kawasan.update');

    Route::delete('/kawasan/{id}', [AdminController::class, 'deleteKawasan'])
        ->name('admin.kawasan.delete');


    // CRUD Pelabuhan
    Route::post('/pelabuhan', [AdminController::class, 'storePelabuhan'])
        ->name('admin.pelabuhan.store');

    Route::put('/pelabuhan/{id}', [AdminController::class, 'updatePelabuhan'])
        ->name('admin.pelabuhan.update');

    Route::delete('/pelabuhan/{id}', [AdminController::class, 'deletePelabuhan'])
        ->name('admin.pelabuhan.delete');


    // CRUD Bandara
    Route::post('/bandara', [AdminController::class, 'storeBandara'])
        ->name('admin.bandara.store');

    Route::put('/bandara/{id}', [AdminController::class, 'updateBandara'])
        ->name('admin.bandara.update');

    Route::delete('/bandara/{id}', [AdminController::class, 'deleteBandara'])
        ->name('admin.bandara.delete');


    // CRUD Jalan
    Route::post('/jalan', [AdminController::class, 'storeJalan'])
        ->name('admin.jalan.store');

    Route::put('/jalan/{id}', [AdminController::class, 'updateJalan'])
        ->name('admin.jalan.update');

    Route::delete('/jalan/{id}', [AdminController::class, 'deleteJalan'])
        ->name('admin.jalan.delete');
});