<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Http\Controllers\GlobalController;
use App\Http\Requests\master\ProdukUlasanStore;
use App\model\master\ProdukUlasan;
use Illuminate\Http\Request;

class ProdukUlasanController extends Controller
{
    public $global;
    public $model;
    public $withCount;

    public function __construct()
    {
        $this->model = new ProdukUlasan;
        $this->global = new GlobalController();
        $this->withCount = ['produk'];
    }

    public function index(Request $request)
    {
        $fields = ['id', 'id_produk', 'id_member', 'deskripsi', 'review', 'gambar', 'id_badge'];
        $withCount = $this->withCount;
        $relations =
            [['produk', ['id', 'nama']], ['member', ['id', 'nama']], ['id_badge', ['id', 'nama']]];
        $where = $request->id_produk ? [['id_produk', '=', $request->id_produk]] : [];
        $has = [];
        $doesntHave = [];
        $with =
            ['produk' => function ($query) {
                $query->select('id', 'nama', 'gambar_utama');
            }, 'member' => function ($query) {
                $query->select('id', 'nama');
            }, 'badge' => function ($query) {
                $query->select('id', 'nama');
            }];

        $data = $this->global->index($this->model, $request, $fields, $with, $withCount, $relations, $where, $has, $doesntHave);

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateOrCreate(ProdukUlasanStore $request)
    {
        $id = ['id' => $request->id ? $request->id : Str::orderedUuid()];
        $data = [
            'id_produk' => $request->id_produk,
            'id_member' => $request->id_member,
            'deskripsi' => $request->deskripsi,
            'review' => $request->review,
            'gambar' => $request->gambar,
            'id_badge' => $request->id_badge,
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
            $valueDecode = $value;

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
        $data = ProdukUlasan::select('id as value', 'nama as text')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getId(Request $request)
    {
        $data = ProdukUlasan::select('id as value', 'nama as text')->where('id', $request->id)->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
