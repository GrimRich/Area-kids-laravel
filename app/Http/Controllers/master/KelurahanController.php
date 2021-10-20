<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\master\KelurahanStore;
use App\Http\Controllers\GlobalController;
use App\model\master\Kelurahan;

class KelurahanController extends Controller
{
    public $global;
    public $model;
    public $withCount;

    public function __construct()
    {
        $this->model = new Kelurahan;
        $this->global = new GlobalController();
        $this->withCount = ['kodePos'];
    }

    public function index(Request $request)
    {
        $where = [];
        $has = [];
        $doesntHave = [];
        $with =
            ['kecamatan' => function ($query) {
                $query->select('id', 'nama');
            }];
        $fields = ['id', 'id_kecamatan', 'nama'];
        $withCount = $this->withCount;
        $relations = [['kecamatan', ['id', 'nama']]];

        $data = $this->global->index($this->model, $request, $fields, $with, $withCount, $relations, $where, $has, $doesntHave);

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateOrCreate(KelurahanStore $request)
    {
        $id = ['id' => $request->id];
        $data = [
            'id_kecamatan' => $request->id_kecamatan,
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
        $data = Kelurahan::select('id as value', 'nama as text')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getId(Request $request)
    {
        $data = Kelurahan::select('id as value', 'nama as text')->where('id', $request->id)->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
