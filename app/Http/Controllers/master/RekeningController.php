<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Http\Requests\master\RekeningStore;
use Illuminate\Support\Str;
use App\model\master\Rekening;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    public $global;
    public $model;
    public $withCount;

    public function __construct()
    {
        $this->model = new Rekening;
        $this->global = new GlobalController();
        $this->withCount = [];
    }

    public function index(Request $request)
    {
        $fields = ['id', 'nama', 'no_rekening', 'id_bank'];
        $withCount = $this->withCount;
        $relations = [['bank', ['id', 'nama', 'nama_singkat']]];
        $where = [];
        $has = [];
        $doesntHave = [];
        $with =
            ['bank' => function ($query) {
                $query->select('id', 'nama', 'nama_singkat');
            }];

        $data = $this->global->index($this->model, $request, $fields, $with, $withCount, $relations, $where, $has, $doesntHave);

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateOrCreate(RekeningStore $request)
    {
        $id = ['id' => $request->id ? $request->id : Str::orderedUuid()];
        $data = [
            'no_rekening' => $request->no_rekening,
            'id_bank' => $request->id_bank,
            'nama' => $request->nama,
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
        $data = Rekening::select('id as value', 'nama as text')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getId(Request $request)
    {
        $data = Rekening::select('id as value', 'nama as text')->where('id', $request->id)->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
