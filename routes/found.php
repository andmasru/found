<?php
namespace App\Http\Controllers\Cars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', [FoundController::class, 'index']); 


Route::get('/cars', [FoundController::class, 'cars']);

Route::get('/drivers', [FoundController::class, 'drivers']);



Route::get('/free', [FoundController::class, 'free']);

Route::get('/busy', [FoundController::class, 'busy']);

Route::get('/start/{idcar}/{iddriver}', [FoundController::class, 'start']);

Route::get('/stop/{idcar}/{iddriver}', [FoundController::class, 'stop']);
 




