<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Http\Requests\master\InformasiStore;
use App\model\master\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InformasiController extends Controller
{
    public $global;
    public $model;
    public $withCount;

    public function __construct()
    {
        $this->model = new Informasi();
        $this->global = new GlobalController();
        $this->withCount = [];
    }

    public function index(Request $request)
    {
        $fields = ['nama', 'logo', 'kontak', 'email', 'facebook', 'instagram', 'youtube', 'twitter', 'alamat', 'shopee', 'tokopedia', 'bukalapak', 'lazada'];
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

    public function updateOrCreate(InformasiStore $request)
    {
        $generateId = Informasi::pluck('id')->first();
        $id = ['id' => $generateId];
        $data = [
            'logo' => is_string($request->logo) ? $request->logo : '',
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'twitter' => $request->twitter,
            'alamat' => $request->alamat,
            'shopee' => $request->shopee,
            'tokopedia' => $request->tokopedia,
            'bukalapak' => $request->bukalapak,
            'lazada' => $request->lazada,
        ];

        $result = $this->global->store($this->model, $id, $data);

        if (!is_string($request->logo)) {
            if ($request->logo != $result->logo && count($request->logo) > 0) {
                $this->global->upload(
                    'image/testimoni/' . $result->id,
                    $request->logo,
                    $result,
                    'logo',
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
