<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/cek-db', function () {
    return DB::connection()->getDatabaseName();
});

Route::get('/', function () {
    return view('welcome');
});
