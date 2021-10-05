<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use Illuminate\Http\Request;
use App\Http\Requests\master\ProvinsiStore;
use App\model\master\Provinsi;

class ProvinsiController extends Controller
{
    public $global;
    public $model;
    public $withCount;

    public function __construct()
    {
        $this->model = new Provinsi;
        $this->global = new GlobalController();
        $this->withCount = ['kota', 'kodePos'];
    }

    public function index(Request $request)
    {
        $fields = ['id', 'nama'];
        $withCount = $this->withCount;
        $relations = [];
        $where = [];
        $has = [];
        $doesntHave = [];
        $with = [];

        $data = $this->global->index($this->model, $request, $fields, $with, $withCount, $relations, $where, $has, $doesntHave);

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateOrCreate(ProvinsiStore $request)
    {
        $id = ['id' => $request->id];
        $data = [
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

        else return response('Internal Server Error', false);
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
        $data = Provinsi::select('id as value', 'nama as text')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getId(Request $request)
    {
        $data = Provinsi::select('id as value', 'nama as text')->where('id', $request->id)->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
