<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsesorController;
use App\Http\Controllers\OrdenController;

Route::get('/', fn() => redirect()->route('ordenes.index'));

Route::resource('asesores', AsesorController::class)->only(['index','create','store']);

// 👇 Forzamos el nombre del parámetro singular a "orden"
Route::resource('ordenes', OrdenController::class)
    ->parameters(['ordenes' => 'orden'])
    ->only(['index','create','store','show']);
