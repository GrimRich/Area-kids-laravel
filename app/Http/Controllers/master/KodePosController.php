<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\master\KodePosStore;
use App\Http\Controllers\GlobalController;
use App\model\master\KodePos;

class KodePosController extends Controller
{
    public $global;
    public $model;
    public $withCount;

    public function __construct()
    {
        $this->model = new KodePos;
        $this->global = new GlobalController();
        $this->withCount = [];
    }

    public function index(Request $request)
    {
        $where = [];
        $has = [];
        $doesntHave = [];
        $with =
            [
                'provinsi' => function ($query) {
                    $query->select('id', 'nama');
                },
                'kota' => function ($query) {
                    $query->select('id', 'nama');
                },
                'kecamatan' => function ($query) {
                    $query->select('id', 'nama');
                },
                'kelurahan' => function ($query) {
                    $query->select('id', 'nama');
                }
            ];
        $fields = ['id', 'id_provinsi', 'id_kota', 'id_kecamatan', 'id_kelurahan', 'kode'];
        $withCount = $this->withCount;
        $relations = [['provinsi', ['id', 'nama']], ['kota', ['id', 'nama']], ['kecamatan', ['id', 'nama']], ['kelurahan', ['id', 'nama']]];

        $data = $this->global->index($this->model, $request, $fields, $with, $withCount, $relations, $where, $has, $doesntHave);

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateOrCreate(KodePosStore $request)
    {
        $id = ['id' => $request->id];
        $data = [
            'id_kelurahan' => $request->id_kecamatan,
            'id_kecamatan' => $request->id_kecamatan,
            'id_kota' => $request->id_kota,
            'id_provinsi' => $request->id_provinsi,
            'kode' => $request->kode,
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
        $data = KodePos::select('id as value', 'nama as text')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getId(Request $request)
    {
        $data = KodePos::select('id as value', 'nama as text')->where('id', $request->id)->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
