<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetDataController;
use App\Http\Controllers\Api\FortuneCardController;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('pet-data/{slug}', [PetDataController::class, 'getPetData']);
Route::get('pet-data-by-id/{petId}', [PetDataController::class, 'getPetDataById']);
Route::get('pet-id-by-line-user/{lineUserId}', [PetDataController::class, 'getPetIdByLineUserId']);

// 寵物小語相關API
Route::get('pet-whisper/random', [\App\Http\Controllers\Api\PetWhisperController::class, 'getRandomWhisper']);
Route::get('pet-whisper/list', [\App\Http\Controllers\Api\PetWhisperController::class, 'getPetWhispers']);
// 占卜卡資料（回傳圖片、覆蓋圖、名字等資料）
Route::get('fortune-card/random', [FortuneCardController::class, 'getRandomFortuneCard']);

// 使用者相關API
Route::get('all-bound-users', [UserController::class, 'getAllBoundUsers']);
