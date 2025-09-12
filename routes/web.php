<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetDataController;
use App\Models\Pet;

Route::get('/', function () {
    return view('index');
});

Route::get('/{slug}', function ($slug) {
    // 獲取寵物數據
    $pet = Pet::where('website_slug', $slug)->first();
    
    if (!$pet) {
        abort(404);
    }
    
    return view('pet', [
        'slug' => $slug,
        'pet' => $pet
    ]);
})->where('slug', '[a-zA-Z0-9\-]+');

