<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Http\Requests\master\MenuStore;
use Illuminate\Support\Str;
use App\model\master\Menu;
use App\model\master\Submenu;
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
        $this->withCount = ['submenuItems'];
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
            }, 'menu'];

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
            }, 'submenuItems'];

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
        try {
            Submenu::where('id_menu', $request->id)->delete();
        } catch (\Throwable $th) {
            print($th);
        }
        try {
            $this->model->destroy($request->id);
        } catch (\Throwable $th) {
            print($th);
        }

        $generateId = $request->id ? $request->id : Str::orderedUuid();
        $id = ['id' => $generateId];
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

        try {
            if ($request->submenu == "1") {
                foreach ($request->submenu_items as $key => $value) {
                    if ($value['nama']) {
                        $submenuModel = new Submenu();
                        $submenuGenerateId = $value['id'] ? $value['id'] : Str::orderedUuid();
                        $submenuId = ['id' => $submenuGenerateId];

                        $submenuData = [
                            'nama' => $value['nama'],
                            'warna' => $value['warna'],
                            'url' => $value['url'],
                            'id_halaman' => $value['id_halaman'],
                            'tipe' => $value['tipe'],
                            'blank' => $value['blank'],
                            'id_kategori_produk' => $value['id_kategori_produk'],
                            'id_menu' => $generateId,
                        ];

                        $this->global->store($submenuModel, $submenuId, $submenuData);
                    }
                }
            }
        } catch (\Throwable $th) {
        }

        $result = $this->global->store($this->model, $id, $data);

        return $result;
    }

    public function destroy(Request $request)
    {
        Submenu::where('id_menu', $request->id)->delete();

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


            $valueDecode = $value;

            Submenu::where('id_menu', $valueDecode['id'])->delete();

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
