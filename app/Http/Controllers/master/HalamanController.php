<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Http\Controllers\GlobalController;
use App\Http\Requests\master\HalamanStore;
use App\model\master\Halaman;
use Illuminate\Http\Request;

class HalamanController extends Controller
{
    public $global;
    public $model;
    public $withCount;

    public function __construct()
    {
        $this->model = new Halaman;
        $this->global = new GlobalController();
        $this->withCount = ['menu', 'submenu'];
    }

    public function index(Request $request)
    {
        $fields = ['id', 'nama', 'isi', 'url', 'static'];
        $withCount = $this->withCount;
        $relations = [];
        $where = [['static', '=', '1']];
        $has = [];
        $doesntHave = [];
        $with = [];

        $data = $this->global->index($this->model, $request, $fields, $with, $withCount, $relations, $where, $has, $doesntHave);

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateOrCreate(HalamanStore $request)
    {
        $id = ['id' => $request->id ? $request->id : Str::orderedUuid()];
        $data = [
            'nama' => $request->nama,
            'isi' => $request->isi,
            'url' => $request->url,
            'static' => $request->static,
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
        $data = Halaman::select('id as value', 'nama as text')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getId(Request $request)
    {
        $data = Halaman::select('id as value', 'nama as text')->where('id', $request->id)->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
