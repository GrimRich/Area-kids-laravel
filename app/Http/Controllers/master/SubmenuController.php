<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Http\Requests\master\SubmenuStore;
use Illuminate\Support\Str;
use App\model\master\Submenu;
use Illuminate\Http\Request;

class SubmenuController extends Controller
{
    public $global;
    public $model;
    public $withCount;

    public function __construct()
    {
        $this->model = new Submenu;
        $this->global = new GlobalController();
        $this->withCount = [];
    }

    public function index(Request $request)
    {
        $fields = ['id', 'id_menu', 'nama', 'warna', 'url', 'id_halaman', 'tipe', 'blank', 'id_kategori_produk'];
        $withCount = $this->withCount;
        $relations = [['halaman', ['id', 'nama']], ['kategoriProduk', ['id', 'nama']], ['menu', ['id', 'nama']]];
        $where = [];
        $has = [];
        $doesntHave = [];
        $with =
            ['halaman' => function ($query) {
                $query->select('id', 'nama');
            }, 'kategoriProduk' => function ($query) {
                $query->select('id', 'nama');
            }, 'menu' => function ($query) {
                $query->select('id', 'nama');
            }];

        $data = $this->global->index($this->model, $request, $fields, $with, $withCount, $relations, $where, $has, $doesntHave);

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateOrCreate(SubmenuStore $request)
    {
        $id = ['id' => $request->id ? $request->id : Str::orderedUuid()];
        $data = [
            'nama' => $request->nama,
            'warna' => $request->warna,
            'url' => $request->url,
            'id_halaman' => $request->id_halaman,
            'tipe' => $request->tipe,
            'blank' => $request->blank,
            'id_kategori_produk' => $request->id_kategori_produk,
            'id_menu' => $request->id_menu,
        ];

        $result = $this->global->store($this->model, $id, $data);

        return $result;
    }

    public function destroy(Request $request)
    {
        $parameter = ['id' => $request->id];
        $withCount = $this->withCount;

        $status = $this->global->destroy($this->model, $parameter, $withCount);

        if ($status) return response()->json([
            'status' => $status
        ]);

        else return response()->json([
            'message' => 'Error'
        ], 200);
    }

    public function destroys(Request $request)
    {
        $success = 0;
        $fail = 0;
        foreach ($request->item as $key => $value) {
            $valueDecode = json_decode($value, true);

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
        $data = Submenu::select('id as value', 'nama as text')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getId(Request $request)
    {
        $data = Submenu::select('id as value', 'nama as text')->where('id', $request->id)->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
