<?php

use App\Http\Controllers\frontend\ProdukController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ProdukController::class, 'produkBaru']);

Route::get('/detail/{alias}', [ProdukController::class, 'produkDetail']);

