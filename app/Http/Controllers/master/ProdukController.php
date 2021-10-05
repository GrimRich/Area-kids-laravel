<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Http\Controllers\GlobalController;
use App\Http\Requests\master\ProdukStore;
use App\model\master\Produk;
use App\model\master\ProdukGambar;
use App\model\master\ProdukUlasan;
use App\model\master\ProdukVarian;
use App\model\master\ProdukVarianPilihan;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public $global;
    public $model;
    public $withCount;

    public function __construct()
    {
        $this->model = new Produk();
        $this->global = new GlobalController();
        $this->withCount = ['produkGambar', 'produkVarian', 'produkUlasan'];
    }

    public function index(Request $request)
    {
        $fields = ['id', 'id_kategori', 'nama', 'deskripsi', 'gambar_utama', 'stok', 'berat', 'harga', 'harga_coret', 'diskon', 'alias', 'tags'];
        $withCount = $this->withCount;
        $relations = [];
        $where = [];
        $has = [];
        $doesntHave = [];
        $relations = [['produkKategori', ['id', 'nama']]];
        $with = ['produkKategori' => function ($query) {
            $query->select('id', 'nama');
        }];


        $data = $this->global->index($this->model, $request, $fields, $with, $withCount, $relations, $where, $has, $doesntHave);

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateOrCreate(ProdukStore $request)
    {
        // Delete if id exist
        if ($this->model->find($request->id)) {
            $variant = ProdukVarian::where('id_produk', $request->id)->pluck('id')->toArray();;
            ProdukVarianPilihan::whereIn('id_produk_varian', $variant)->delete();
            ProdukVarian::where('id_produk', $request->id)->delete();
            ProdukGambar::where('id_produk', $request->id)->delete();
            ProdukUlasan::where('id_produk', $request->id)->delete();
            $this->model->destroy($request->id);
        }

        $generateId = $request->id ? $request->id : Str::orderedUuid();

        $id = ['id' => $generateId];

        $data = [
            'nama' => $request->nama,
            'id_kategori' => $request->id_kategori,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'berat' => $request->berat,
            'harga' => $request->harga,
            'harga_coret' => $request->harga_coret,
            'diskon' => $request->diskon,
            'alias' => $request->alias,
            'tags' => $request->tags,
        ];

        // Update or Create data

        $result = $this->global->store($this->model, $id, $data);

        // Upload Image
        if ($request->gambar_utama != $result->gambar_utama && count($request->gambar_utama) > 0) {
            $this->global->upload(
                'image/produk/' . $result->id,
                $request->gambar_utama,
                $result,
                'gambar_utama',
                $generateId,
                'utama'
            );
        }

        // Foreach gambar
        foreach ($request->gambar as $key => $value) {
            $gambarModel = new ProdukGambar();
            $gambarGenerateId = $value['id'] ? $value['id'] : Str::orderedUuid();
            $gambarId = ['id' => $gambarGenerateId];

            $gambarData = [
                'id' => $gambarGenerateId,
                'id_produk' => $generateId,
            ];

            // Update or Create gambar
            $gambarResult = $this->global->store($gambarModel, $gambarId, $gambarData);

            // Upload image gambar
            if ($value != $gambarResult->gambar && count($value) > 0) {
                $this->global->upload(
                    'image/produk/' . $generateId,
                    $value['gambar'],
                    $gambarResult,
                    'gambar',
                    $gambarGenerateId . $key,
                    'gambar'
                );
            }
        }

        // Foreach Varian
        foreach ($request->varian as $varianKey => $valueVarian) {
            $varianModel = new ProdukVarian();
            $varianGenerateId = $valueVarian['id'] ? $valueVarian['id'] : Str::orderedUuid();
            $varianId = ['id' => $varianGenerateId];

            $varianData = [
                'id' => $varianGenerateId,
                'id_produk' => $generateId,
                'nama' => $valueVarian['nama'],
            ];

            // Update or create varian
            $this->global->store($varianModel, $varianId, $varianData);

            // Foreach Pilihan
            foreach ($valueVarian['pilihan'] as $pilihanKey => $valuePilihan) {
                $pilihanModel = new ProdukVarianPilihan();
                $pilihanGenerateId = $request->id ? $request->id : Str::orderedUuid();
                $pilihanId = ['id' => $pilihanGenerateId];

                $pilihanData = [
                    'id' => $pilihanGenerateId,
                    'id_produk_varian' => $varianGenerateId,
                    'nama' => $valuePilihan['nama'],
                    'harga' => $valuePilihan['harga'],
                    'harga_seller' => $valuePilihan['harga_seller'],
                    'stok' => $valuePilihan['stok'],
                ];

                // Update or create pilihan
                $pilihanResult = $this->global->store($pilihanModel, $pilihanId, $pilihanData);

                // Upload pilihan image
                if ($valuePilihan != $pilihanResult->gambar && count($valuePilihan) > 0) {
                    $this->global->upload('image/produk/' . $generateId, $valuePilihan['gambar'], $pilihanResult, 'gambar', $pilihanGenerateId . $pilihanKey, 'pilihan');
                }
            }
        }

        return response()->json([
            'data' => true
        ]);
    }

    public function destroy(Request $request)
    {
        $variant = ProdukVarian::where('id_produk', $request->id)->pluck('id')->toArray();
        ProdukVarianPilihan::whereIn('id_produk_varian', $variant)->delete();
        ProdukVarian::where('id_produk', $request->id)->delete();
        ProdukGambar::where('id_produk', $request->id)->delete();
        ProdukUlasan::where('id_produk', $request->id)->delete();

        $parameter = ['id' => $request->id];
        $withCount = $this->withCount;
        var_dump($withCount);

        $status = $this->global->destroy($this->model, $parameter, $withCount);

        return response()->json([
            'status' => $status
        ]);
    }

    public function destroys(Request $request)
    {
        $success = 0;
        $fail = 0;
        foreach ($request->item as $key => $value) {
            $valueDecode = json_decode($value, true);

            $variant = ProdukVarian::where('id_produk', $valueDecode['id'])->pluck('id')->toArray();

            ProdukVarianPilihan::whereIn('id_produk_varian', $variant)->delete();
            ProdukVarian::where('id_produk', $valueDecode['id'])->delete();
            ProdukGambar::where('id_produk', $valueDecode['id'])->delete();
            ProdukUlasan::where('id_produk', $valueDecode['id'])->delete();

            $parameter = ['id' => $valueDecode['id']];

            $result = $this->global->destroy($this->model, $parameter, $this->withCount);


            if ($result) {
                $success++;
            } else {
                $fail++;
            }

            $status[] = $result;
        }

        return response()->json([
            'status' => $status,
            'success' => $success,
            'fail' => $fail
        ]);
    }

    public function get(Request $request)
    {
        $data = Produk::select('id as value', 'nama as text')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getId(Request $request)
    {
        $data = Produk::select('id as value', 'nama as text')->where('id', $request->id)->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
