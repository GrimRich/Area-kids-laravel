<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Model\master\produk;
use Illuminate\Support\Collection;

class ProdukController extends Controller
{
    public function produkBaru(){
        $produkBaru         = Produk::orderBy("created_at", "desc")->get();
        $semuaProduk        = Produk::limit("8")->get();

        
        return view('home', 
            [
                'produkBaru' => $produkBaru,
                'semuaProduk' => $semuaProduk
            ]);
    }

    public function produkDetail($alias){
        $produkDetail       = Produk::with(['produkGambar', 'produkVarian.produkVarianPilihan'])->where("alias", $alias)->first();

        $idProduk           = $produkDetail->first()->id;
        $idKatProdukSelect  = $produkDetail->first()->id_kategori;
        $produkRelated      = Produk::where("id_kategori", $idKatProdukSelect)->where("id", "!=", $idProduk)->limit(8)->get();

        return view('detailProduk', 
            [
                'produkDetail' => $produkDetail,
                'produkRelated' => $produkRelated,
            ]);

        return view('detailProduk');
    }
}