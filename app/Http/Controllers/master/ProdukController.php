<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Http\Controllers\GlobalController;
use App\Http\Requests\master\ProdukStore;
use App\model\master\Produk;
use App\model\master\ProdukGambar;
use App\model\master\ProdukSeleksi;
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
        $fields = ['id', 'id_kategori', 'nama', 'deskripsi', 'gambar_utama', 'stok', 'berat', 'harga', 'harga_coret', 'diskon', 'harga_min', 'harga_max', 'alias', 'tags', 'tampil', 'nama_variasi'];
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

    public function indexCoba($home)
    {
        return view('welcome', [
            'home' => $home
        ]);
    }

    public function updateOrCreate(ProdukStore $request)
    {
        if ($this->model->find($request->id)) {
            try {
                $variant = ProdukSeleksi::where('id_produk', $request->id)->delete();
            } catch (\Throwable $th) {
                print($th);
            }
            try {
                $variant = ProdukVarian::where('id_produk', $request->id)->pluck('id')->toArray();
            } catch (\Throwable $th) {
                print($th);
            }
            try {
                ProdukVarianPilihan::whereIn('id_produk_varian', $variant)->delete();
            } catch (\Throwable $th) {
                print($th);
            }
            try {
                ProdukVarian::where('id_produk', $request->id)->delete();
            } catch (\Throwable $th) {
                print($th);
            }
            try {
                ProdukGambar::where('id_produk', $request->id)->delete();
            } catch (\Throwable $th) {
                print($th);
            }
            try {
                ProdukUlasan::where('id_produk', $request->id)->delete();
            } catch (\Throwable $th) {
                print($th);
            }
            try {
                $this->model->destroy($request->id);
            } catch (\Throwable $th) {
                print($th);
            }
        }

        $generateId = $request->id ? $request->id : Str::orderedUuid();

        try {
            try {
                $id = ['id' => $generateId];

                $data = [
                    'nama' => $request->nama,
                    'id_kategori' => $request->id_kategori,
                    'nama' => $request->nama,
                    'deskripsi' => $request->deskripsi,
                    'stok' => $request->stok,
                    'berat' => $request->berat,
                    'harga' => $request->harga,
                    'harga_min' => $request->harga_min,
                    'harga_max' => $request->harga_max,
                    'harga_coret' => $request->harga_coret,
                    'diskon' => $request->diskon,
                    'alias' => $request->alias,
                    'tags' => $request->tags,
                    'tampil' => $request->tampil,
                    'gambar_utama' => is_string($request->gambar_utama) ? $request->gambar_utama : '',
                    'panduan_ukuran' => is_string($request->panduan_ukuran) ? $request->panduan_ukuran : '',
                    'nama_variasi' => $request->nama_variasi,
                ];

                // Update or Create data

                $result = $this->global->store($this->model, $id, $data);

                // Upload Image
                if (!is_string($request->gambar_utama)) {
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
                }

                if (!is_string($request->panduan_ukuran)) {
                    if ($request->panduan_ukuran != $result->panduan_ukuran && count($request->panduan_ukuran) > 0) {
                        $this->global->upload(
                            'image/produk/' . $result->id,
                            $request->panduan_ukuran,
                            $result,
                            'panduan_ukuran',
                            $generateId,
                            'panduan_ukuran'
                        );
                    }
                }
                //code...
            } catch (\Throwable $th) {
                print($th);
                //throw $th;
            }

            try {
                //code...
                foreach ($request->produk_gambar as $key => $value) {
                    if ($value['gambar']) {
                        $gambarModel = new ProdukGambar();
                        $gambarGenerateId = $value['id'] ? $value['id'] : Str::orderedUuid();
                        $gambarId = ['id' => $gambarGenerateId];

                        $gambarData = [
                            'id' => $gambarGenerateId,
                            'id_produk' => $generateId,
                            'gambar' => is_string($value['gambar']) ? $value['gambar'] : ''
                        ];

                        if (!is_string($value['gambar']) && $value['id']) {
                        }

                        // Update or Create gambar
                        $gambarResult = $this->global->store($gambarModel, $gambarId, $gambarData);

                        // Upload image gambar
                        if (!is_string($value['gambar'])) {
                            if ($value['gambar'] != $gambarResult->gambar && count($value) > 0) {
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
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                print($th);
            }

            // Foreach gambar

            $seleksiArr = array();

            try {
                //code...
                foreach ($request->produk_seleksi as $key => $valueSeleksi) {
                    if ($valueSeleksi['nama']) {
                        $seleksiModel = new ProdukSeleksi();
                        $seleksiGenerateId = $valueSeleksi['id'] ? $valueSeleksi['id'] : Str::orderedUuid();
                        $seleksiId = ['id' => $seleksiGenerateId];

                        array_push($seleksiArr, strval($seleksiGenerateId));

                        $seleksiData = [
                            'id' => $seleksiGenerateId,
                            'nama' => $valueSeleksi['nama'],
                        ];

                        // Update or Create seleksi
                        $this->global->store($seleksiModel, $seleksiId, $seleksiData);
                    }
                }
            } catch (\Throwable $th) {
                print($th);
                //throw $th;
            }

            try {
                //code...
                foreach ($request->produk_varian as $varianKey => $valueVarian) {
                    if ($valueVarian['nama']) {
                        $varianModel = new ProdukVarian();
                        $varianGenerateId = $valueVarian['id'] ? $valueVarian['id'] : Str::orderedUuid();
                        $varianId = ['id' => $varianGenerateId];

                        $varianData = [
                            'id' => $varianGenerateId,
                            'id_produk' => $generateId,
                            'id_seleksi' => count($seleksiArr) > 0 ? $seleksiArr[0] : '',
                            'nama' => $valueVarian['nama'],
                            'gambar' => is_string($valueVarian['gambar']) ? $valueVarian['gambar'] : '',
                        ];

                        // Update or create varian
                        $VarianResult = $this->global->store($varianModel, $varianId, $varianData);

                        if (!is_string($valueVarian['gambar'])) {
                            if ($valueVarian['gambar'] != $VarianResult->gambar && count($valueVarian) > 0) {
                                $this->global->upload('image/produk/' . $generateId, $valueVarian['gambar'], $VarianResult, 'gambar', $varianGenerateId . Str::orderedUuid(), 'pilihan');
                            }
                        }

                        // Foreach Pilihan
                        foreach ($valueVarian['produk_varian_pilihan'] as $pilihanKey => $valuePilihan) {
                            if ($valuePilihan['nama']) {
                                $pilihanModel = new ProdukVarianPilihan();
                                $pilihanGenerateId = $valuePilihan['id'] ? $valuePilihan['id'] : Str::orderedUuid();
                                $pilihanId = ['id' => $pilihanGenerateId];

                                $pilihanData = [
                                    'id' => $pilihanGenerateId,
                                    'id_produk_varian' => $varianGenerateId,
                                    'nama' => $valuePilihan['nama'],
                                    'harga' => $valuePilihan['harga'],
                                    'harga_coret' => $valuePilihan['harga_coret'],
                                    'harga_seller' => $valuePilihan['harga_seller'],
                                    'id_seleksi' => count($seleksiArr) > 1 ? $seleksiArr[1] : '',
                                    'id_produk' => $generateId,
                                    'stok' => $valuePilihan['stok'],
                                    'tampil' => $valuePilihan['tampil'],
                                ];

                                // Update or create pilihan
                                $this->global->store($pilihanModel, $pilihanId, $pilihanData);
                            }
                        }
                    }
                }
            } catch (\Throwable $th) {
                print($th);
                //throw $th;
            }
            // Foreach Varian

            return response()->json([
                'data' => true
            ]);
        } catch (\Throwable $th) {
            try {
                $variant = ProdukSeleksi::where('id_produk', $request->id)->delete();
            } catch (\Throwable $th) {
                print($th);
            }
            try {
                $variant = ProdukVarian::where('id_produk', $request->id)->pluck('id')->toArray();
            } catch (\Throwable $th) {
                print($th);
            }
            try {
                ProdukVarianPilihan::whereIn('id_produk_varian', $variant)->delete();
            } catch (\Throwable $th) {
                print($th);
            }
            try {
                ProdukVarian::where('id_produk', $request->id)->delete();
            } catch (\Throwable $th) {
                print($th);
            }
            try {
                ProdukGambar::where('id_produk', $request->id)->delete();
            } catch (\Throwable $th) {
                print($th);
            }
            try {
                ProdukUlasan::where('id_produk', $request->id)->delete();
            } catch (\Throwable $th) {
                print($th);
            }
            try {
                $this->model->destroy($request->id);
            } catch (\Throwable $th) {
                print($th);
            }

            print($th);
        }
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

    public function ishide(Request $request)
    {
        $data = Produk::where('id', $request->id)->update(['tampil' => $request->tampil]);

        return response()->json([
            'data' => $data
        ]);
    }

    public function get(Request $request)
    {
        $data = Produk::select('id as value', 'nama as text', 'gambar_utama')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getId(Request $request)
    {
        $data = Produk::with(['produkGambar', 'produkVarian.produkVarianPilihan'])->where('id', $request->id)->first();

        $seleksi = ProdukSeleksi::whereHas('produkVarian', function ($query) use ($request) {
            return $query->where('id_produk', $request->id);
        })->orWhereHas('produkVarianPilihan', function ($query) use ($request) {
            return $query->where('id_produk', $request->id);
        })->get();

        return response()->json([
            'data' => $data,
            'seleksi' => $seleksi
        ]);
    }
}
