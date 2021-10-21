<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Http\Requests\master\TestimoniStore;
use App\model\master\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TestimoniController extends Controller
{
    public $global;
    public $model;
    public $withCount;

    public function __construct()
    {
        $this->model = new Testimoni();
        $this->global = new GlobalController();
        $this->withCount = [];
    }

    public function index(Request $request)
    {
        $fields = ['id', 'gambar', 'nama', 'deskripsi'];
        $withCount = $this->withCount;
        $where = [];
        $has = [];
        $doesntHave = [];
        $with = [];
        $relations = [];

        $data = $this->global->index($this->model, $request, $fields, $with, $withCount, $relations, $where, $has, $doesntHave);

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateOrCreate(TestimoniStore $request)
    {
        $generateId = $request->id ? $request->id : Str::orderedUuid();
        $id = ['id' => $generateId];
        $data = [
            'gambar' => is_string($request->gambar) ? $request->gambar : '',
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ];

        $result = $this->global->store($this->model, $id, $data);

        if (!is_string($request->gambar)) {
            if ($request->gambar != $result->gambar && count($request->gambar) > 0) {
                $this->global->upload(
                    'image/testimoni/' . $result->id,
                    $request->gambar,
                    $result,
                    'gambar',
                    $generateId,
                );
            }
        }

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

    public function ishide(Request $request)
    {
        $data = $this->model->where('id', $request->id)->update(['tampil' => $request->tampil]);

        return response()->json([
            'data' => $data
        ]);
    }

    public function get(Request $request)
    {
        $data = $this->model->select('id as value', 'nama as text')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getId(Request $request)
    {
        $data = $this->model->select('id as value', 'nama as text')->where('id', $request->id)->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
