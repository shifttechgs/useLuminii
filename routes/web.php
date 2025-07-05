<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('useluminii');
});

Route::get('/useluminii', function () {
    return view('useluminii');
});
