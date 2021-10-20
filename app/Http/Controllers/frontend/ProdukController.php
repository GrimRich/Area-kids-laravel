<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\model\master\Produk;
use App\model\master\ProdukKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function produkBaru()
    {
        $produkBaru         = Produk::orderBy("created_at", "desc")->get();
        $semuaProduk        = Produk::limit("8")->get();


        return view(
            'home',
            [
                'produkBaru' => $produkBaru,
                'semuaProduk' => $semuaProduk
            ]
        );
    }

    public function produkDetail($alias)
    {
        $produkDetail       = Produk::with(['produkGambar', 'produkVarian.produkVarianPilihan'])->where("alias", $alias)->first();

        $idProduk           = $produkDetail->first()->id;
        $idKatProdukSelect  = $produkDetail->first()->id_kategori;
        $produkRelated      = Produk::where("id_kategori", $idKatProdukSelect)->where("id", "!=", $idProduk)->limit(8)->get();

        return view(
            'detailProduk',
            [
                'produkDetail' => $produkDetail,
                'produkRelated' => $produkRelated,
            ]
        );

        return view('detailProduk');
    }

    public function createTransaction(Request $request)
    {

        $produk = ProdukKategori::create(
            ['id' => Str::orderedUuid(), 'nama' => $request->first_name],
        );

        return redirect('/');
    }
}
