<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/{slug}', function ($slug) {
    return view('pet', ['slug' => $slug]);
})->where('slug', '[a-zA-Z0-9\-]+');

