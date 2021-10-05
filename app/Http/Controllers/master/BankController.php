<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Http\Controllers\GlobalController;
use App\Http\Requests\master\BankStore;
use App\model\master\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public $global;
    public $model;
    public $withCount;

    public function __construct()
    {
        $this->model = new Bank;
        $this->global = new GlobalController();
        $this->withCount = ['rekening'];
    }

    public function index(Request $request)
    {
        $fields = ['id', 'nama', 'nama_singkat'];
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

    public function updateOrCreate(BankStore $request)
    {
        $id = ['id' => $request->id ? $request->id : Str::orderedUuid()];
        $data = [
            'nama' => $request->nama,
            'nama_singkat' => $request->nama_singkat,
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
        $data = Bank::select('id as value', 'nama as text')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getId(Request $request)
    {
        $data = Bank::select('id as value', 'nama as text')->where('id', $request->id)->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
