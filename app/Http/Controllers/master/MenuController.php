<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Http\Requests\master\MenuStore;
use Illuminate\Support\Str;
use App\model\master\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public $global;
    public $model;
    public $withCount;

    public function __construct()
    {
        $this->model = new Menu;
        $this->global = new GlobalController();
        $this->withCount = ['submenu'];
    }

    public function index(Request $request)
    {
        $fields = ['id', 'nama', 'warna', 'url', 'id_halaman', 'tipe', 'blank', 'id_kategori_produk', 'submenu', 'is_footer', 'tipe_footer'];
        $withCount = $this->withCount;
        $relations = [['halaman', ['id', 'nama']], ['kategoriProduk', ['id', 'nama']]];
        $where = [['is_footer', '=', '0']];
        $has = [];
        $doesntHave = [];
        $with =
            ['halaman' => function ($query) {
                $query->select('id', 'nama');
            }, 'kategoriProduk' => function ($query) {
                $query->select('id', 'nama');
            }];

        $data = $this->global->index($this->model, $request, $fields, $with, $withCount, $relations, $where, $has, $doesntHave);

        return response()->json([
            'data' => $data
        ]);
    }

    public function indexLinkPenting(Request $request)
    {
        $fields = ['id', 'nama', 'warna', 'url', 'id_halaman', 'tipe', 'blank', 'id_kategori_produk', 'submenu', 'is_footer', 'tipe_footer'];
        $withCount = $this->withCount;
        $relations = [['halaman', ['id', 'nama']], ['kategoriProduk', ['id', 'nama']]];
        $where = [['tipe_footer', '=', '0']];
        $has = [];
        $doesntHave = [];
        $with =
            ['halaman' => function ($query) {
                $query->select('id', 'nama');
            }, 'kategoriProduk' => function ($query) {
                $query->select('id', 'nama');
            }];

        $data = $this->global->index($this->model, $request, $fields, $with, $withCount, $relations, $where, $has, $doesntHave);

        return response()->json([
            'data' => $data
        ]);
    }

    public function indexDiscover(Request $request)
    {
        $fields = ['id', 'nama', 'warna', 'url', 'id_halaman', 'tipe', 'blank', 'id_kategori_produk', 'submenu', 'is_footer', 'tipe_footer'];
        $withCount = $this->withCount;
        $relations = [['halaman', ['id', 'nama']], ['kategoriProduk', ['id', 'nama']]];
        $where = [['tipe_footer', '=', '1']];
        $has = [];
        $doesntHave = [];
        $with =
            ['halaman' => function ($query) {
                $query->select('id', 'nama');
            }, 'kategoriProduk' => function ($query) {
                $query->select('id', 'nama');
            }];

        $data = $this->global->index($this->model, $request, $fields, $with, $withCount, $relations, $where, $has, $doesntHave);

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateOrCreate(MenuStore $request)
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
            'submenu' => $request->submenu,
            'is_footer' => $request->is_footer,
            'tipe_footer' => $request->tipe_footer,
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
        $data = Menu::select('id as value', 'nama as text')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getId(Request $request)
    {
        $data = Menu::select('id as value', 'nama as text')->where('id', $request->id)->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
