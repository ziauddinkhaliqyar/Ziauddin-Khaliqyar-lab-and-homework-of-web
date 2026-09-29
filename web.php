<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'course' => 'Web Information Systems'
    ]);
});

Route::get('/about', function () {
    return view('about');
});
