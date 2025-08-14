<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('inventory');
});

Route::get('/inventory', function () {
    return view('inventory');
});

