<?php

use App\Http\Controllers\frontend\ProdukController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::get('/', [ProdukController::class, 'produkBaru']);

Route::get('/detail/{alias}', [ProdukController::class, 'produkDetail']);

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:cache');
});

Route::get('/storage-links', function () {
    $exitCode = Artisan::call('storage:link');
});
