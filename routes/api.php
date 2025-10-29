<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetDataController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('pet-data/{slug}', [PetDataController::class, 'getPetData']);
Route::get('pet-data-by-id/{petId}', [PetDataController::class, 'getPetDataById']);
Route::get('pet-id-by-line-user/{lineUserId}', [PetDataController::class, 'getPetIdByLineUserId']);

// 寵物小語相關API
Route::get('pet-whisper/random', [\App\Http\Controllers\Api\PetWhisperController::class, 'getRandomWhisper']);
Route::get('pet-whisper/list', [\App\Http\Controllers\Api\PetWhisperController::class, 'getPetWhispers']);
