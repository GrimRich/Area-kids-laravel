<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

Route::middleware('auth:api')->group(function () {
    Route::prefix('badge')->group(function () {
        Route::get('/', 'master\BadgeController@index');
        Route::post('update-or-create', 'master\BadgeController@updateOrCreate');
        Route::post('delete', 'master\BadgeController@destroy');
        Route::post('delete-multiple', 'master\BadgeController@destroys');
        Route::get('get', 'master\BadgeController@get');
        Route::get('get-id', 'master\BadgeController@getId');
    });
    Route::prefix('bank')->group(function () {
        Route::get('/', 'master\BankController@index');
        Route::post('update-or-create', 'master\BankController@updateOrCreate');
        Route::post('delete', 'master\BankController@destroy');
        Route::post('delete-multiple', 'master\BankController@destroys');
        Route::get('get', 'master\BankController@get');
        Route::get('get-id', 'master\BankController@getId');
    });
    Route::prefix('menu')->group(function () {
        Route::get('/', 'master\MenuController@index');
        Route::post('update-or-create', 'master\MenuController@updateOrCreate');
        Route::post('delete', 'master\MenuController@destroy');
        Route::post('delete-multiple', 'master\MenuController@destroys');
        Route::get('get', 'master\MenuController@get');
        Route::get('get-id', 'master\MenuController@getId');
    });
    Route::prefix('submenu')->group(function () {
        Route::get('/', 'master\SubmenuController@index');
        Route::post('update-or-create', 'master\SubmenuController@updateOrCreate');
        Route::post('delete', 'master\SubmenuController@destroy');
        Route::post('delete-multiple', 'master\SubmenuController@destroys');
        Route::get('get', 'master\SubmenuController@get');
        Route::get('get-id', 'master\SubmenuController@getId');
    });
    Route::prefix('link-penting')->group(function () {
        Route::get('/', 'master\MenuController@indexLinkPenting');
        Route::post('update-or-create', 'master\MenuController@updateOrCreate');
        Route::post('delete', 'master\MenuController@destroy');
        Route::post('delete-multiple', 'master\MenuController@destroys');
        Route::get('get', 'master\MenuController@get');
        Route::get('get-id', 'master\MenuController@getId');
    });
    Route::prefix('discover')->group(function () {
        Route::get('/', 'master\MenuController@indexDiscover');
        Route::post('update-or-create', 'master\MenuController@updateOrCreate');
        Route::post('delete', 'master\MenuController@destroy');
        Route::post('delete-multiple', 'master\MenuController@destroys');
        Route::get('get', 'master\MenuController@get');
        Route::get('get-id', 'master\MenuController@getId');
    });
    Route::prefix('halaman')->group(function () {
        Route::get('/', 'master\HalamanController@index');
        Route::post('update-or-create', 'master\HalamanController@updateOrCreate');
        Route::post('delete', 'master\HalamanController@destroy');
        Route::post('delete-multiple', 'master\HalamanController@destroys');
        Route::get('get', 'master\HalamanController@get');
        Route::get('get-id', 'master\HalamanController@getId');
    });
    Route::prefix('banner')->group(function () {
        Route::get('/', 'master\BannerController@index');
        Route::post('update-or-create', 'master\BannerController@updateOrCreate');
        Route::post('delete', 'master\BannerController@destroy');
        Route::post('delete-multiple', 'master\BannerController@destroys');
        Route::post('ishide', 'master\BannerController@ishide');
        Route::get('get', 'master\BannerController@get');
        Route::get('get-id', 'master\BannerController@getId');
    });
    Route::prefix('keranjang')->group(function () {
        Route::get('/', 'master\KeranjangController@index');
        Route::post('update-or-create', 'master\KeranjangController@updateOrCreate');
        Route::post('delete', 'master\KeranjangController@destroy');
        Route::post('delete-multiple', 'master\KeranjangController@destroys');
        Route::get('get', 'master\KeranjangController@get');
        Route::get('get-id', 'master\KeranjangController@getId');
    });
    Route::prefix('informasi')->group(function () {
        Route::get('/', 'master\InformasiController@index');
        Route::post('update-or-create', 'master\InformasiController@updateOrCreate');
        Route::post('delete', 'master\InformasiController@destroy');
        Route::post('delete-multiple', 'master\InformasiController@destroys');
        Route::get('get', 'master\InformasiController@get');
        Route::get('get-id', 'master\InformasiController@getId');
    });
    Route::prefix('member')->group(function () {
        Route::get('/', 'master\MemberController@index');
        Route::post('update-or-create', 'master\MemberController@updateOrCreate');
        Route::post('delete', 'master\MemberController@destroy');
        Route::post('delete-multiple', 'master\MemberController@destroys');
        Route::get('get', 'master\MemberController@get');
        Route::get('get-id', 'master\MemberController@getId');
    });
    Route::prefix('member-alamat')->group(function () {
        Route::get('/', 'master\MemberAlamatController@index');
        Route::post('update-or-create', 'master\MemberAlamatController@updateOrCreate');
        Route::post('delete', 'master\MemberAlamatController@destroy');
        Route::post('delete-multiple', 'master\MemberAlamatController@destroys');
        Route::get('get', 'master\MemberAlamatController@get');
        Route::get('get-id', 'master\MemberAlamatController@getId');
    });
    Route::prefix('produk')->group(function () {
        Route::get('/', 'master\ProdukController@index');
        Route::post('produk/update-or-create', 'master\ProdukController@updateOrCreate');
        Route::post('delete', 'master\ProdukController@destroy');
        Route::post('delete-multiple', 'master\ProdukController@destroys');
        Route::get('get', 'master\ProdukController@get');
        Route::get('get-id', 'master\ProdukController@getId');
        Route::post('ishide', 'master\ProdukController@ishide');
    });
    Route::prefix('produk-gambar')->group(function () {
        Route::get('/', 'master\ProdukGambarController@index');
        Route::post('update-or-create', 'master\ProdukGambarController@updateOrCreate');
        Route::post('delete', 'master\ProdukGambarController@destroy');
        Route::post('delete-multiple', 'master\ProdukGambarController@destroys');
        Route::get('get', 'master\ProdukGambarController@get');
        Route::get('get-id', 'master\ProdukGambarController@getId');
    });
    Route::prefix('produk-kategori')->group(function () {
        Route::get('/', 'master\ProdukKategoriController@index');
        Route::post('update-or-create', 'master\ProdukKategoriController@updateOrCreate');
        Route::post('delete', 'master\ProdukKategoriController@destroy');
        Route::post('delete-multiple', 'master\ProdukKategoriController@destroys');
        Route::get('get', 'master\ProdukKategoriController@get');
        Route::get('get-id', 'master\ProdukKategoriController@getId');
    });
    Route::prefix('produk-ulasan')->group(function () {
        Route::get('/', 'master\ProdukUlasanController@index');
        Route::post('update-or-create', 'master\ProdukUlasanController@updateOrCreate');
        Route::post('delete', 'master\ProdukUlasanController@destroy');
        Route::post('delete-multiple', 'master\ProdukUlasanController@destroys');
        Route::get('get', 'master\ProdukUlasanController@get');
        Route::get('get-id', 'master\ProdukUlasanController@getId');
    });
    Route::prefix('produk-varian')->group(function () {
        Route::get('/', 'master\ProdukVarianController@index');
        Route::post('update-or-create', 'master\ProdukVarianController@updateOrCreate');
        Route::post('delete', 'master\ProdukVarianController@destroy');
        Route::post('delete-multiple', 'master\ProdukVarianController@destroys');
        Route::get('get', 'master\ProdukVarianController@get');
        Route::get('get-id', 'master\ProdukVarianController@getId');
    });
    Route::prefix('produk-varian-pilihan')->group(function () {
        Route::get('/', 'master\ProdukVarianPilihanController@index');
        Route::post('update-or-create', 'master\ProdukVarianPilihanController@updateOrCreate');
        Route::post('delete', 'master\ProdukVarianPilihanController@destroy');
        Route::post('delete-multiple', 'master\ProdukVarianPilihanController@destroys');
        Route::get('get', 'master\ProdukVarianPilihanController@get');
        Route::get('get-id', 'master\ProdukVarianPilihanController@getId');
    });
    Route::prefix('rekening')->group(function () {
        Route::get('/', 'master\RekeningController@index');
        Route::post('update-or-create', 'master\RekeningController@updateOrCreate');
        Route::post('delete', 'master\RekeningController@destroy');
        Route::post('delete-multiple', 'master\RekeningController@destroys');
        Route::get('get', 'master\RekeningController@get');
        Route::get('get-id', 'master\RekeningController@getId');
    });
    Route::prefix('testimoni')->group(function () {
        Route::get('/', 'master\TestimoniController@index');
        Route::post('update-or-create', 'master\TestimoniController@updateOrCreate');
        Route::post('delete', 'master\TestimoniController@destroy');
        Route::post('delete-multiple', 'master\TestimoniController@destroys');
        Route::get('get', 'master\TestimoniController@get');
        Route::get('get-id', 'master\TestimoniController@getId');
    });
    Route::prefix('provinsi')->group(function () {
        Route::get('/', 'master\ProvinsiController@index');
        Route::post('update-or-create', 'master\ProvinsiController@updateOrCreate');
        Route::post('delete', 'master\ProvinsiController@destroy');
        Route::post('delete-multiple', 'master\ProvinsiController@destroys');
        Route::get('get', 'master\ProvinsiController@get');
        Route::get('get-id', 'master\ProvinsiController@getId');
    });
    Route::prefix('kota')->group(function () {
        Route::get('/', 'master\KotaController@index');
        Route::post('update-or-create', 'master\KotaController@updateOrCreate');
        Route::post('delete', 'master\KotaController@destroy');
        Route::post('delete-multiple', 'master\KotaController@destroys');
        Route::get('get', 'master\KotaController@get');
        Route::get('get-id', 'master\KotaController@getId');
    });
    Route::prefix('kecamatan')->group(function () {
        Route::get('/', 'master\KecamatanController@index');
        Route::post('update-or-create', 'master\KecamatanController@updateOrCreate');
        Route::post('delete', 'master\KecamatanController@destroy');
        Route::post('delete-multiple', 'master\KecamatanController@destroys');
        Route::get('get', 'master\KecamatanController@get');
        Route::get('get-id', 'master\KecamatanController@getId');
    });
    Route::prefix('kelurahan')->group(function () {
        Route::get('/', 'master\KelurahanController@index');
        Route::post('update-or-create', 'master\KelurahanController@updateOrCreate');
        Route::post('delete', 'master\KelurahanController@destroy');
        Route::post('delete-multiple', 'master\KelurahanController@destroys');
        Route::get('get', 'master\KelurahanController@get');
        Route::get('get-id', 'master\KelurahanController@getId');
    });
    Route::prefix('kode-pos')->group(function () {
        Route::get('/', 'master\KodePosController@index');
        Route::post('update-or-create', 'master\KodePosController@updateOrCreate');
        Route::post('delete', 'master\KodePosController@destroy');
        Route::post('delete-multiple', 'master\KodePosController@destroys');
        Route::get('get', 'master\KodePosController@get');
        Route::get('get-id', 'master\KodePosController@getId');
    });
});
