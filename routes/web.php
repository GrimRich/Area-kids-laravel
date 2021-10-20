<?php

use App\Http\Controllers\frontend\ProdukController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::get('/', [ProdukController::class, 'produkBaru']);

Route::get('/detail/{alias}', [ProdukController::class, 'produkDetail']);

Route::post('/post-data', [ProdukController::class, 'createTransaction']);

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:cache');
});

Route::get('/storage-link', function () {
    $exitCode = Artisan::call('storage:link');
});
