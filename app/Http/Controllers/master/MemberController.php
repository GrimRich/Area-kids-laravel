<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Http\Requests\master\MemberStore;
use App\model\master\Member;
use App\model\master\MemberAlamat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public $global;
    public $model;
    public $withCount;

    public function __construct()
    {
        $this->model = new Member();
        $this->global = new GlobalController();
        $this->withCount = [];
    }

    public function index(Request $request)
    {
        $fields = ['id', 'nama', 'email', 'no_hp', 'password'];
        $withCount = $this->withCount;
        $where = [];
        $has = [];
        $doesntHave = [];
        $with =
            ['memberAlamat' => function ($query) {
                $query->select('id', 'id_member', 'judul_alamat', 'id_provinsi', 'id_kota', 'id_kecamatan', 'id_kelurahan', 'kode_pos', 'alamat', 'status');
            }];;
        $relations =
            [['memberAlamat', ['id', 'id_member', 'judul_alamat', 'id_provinsi', 'id_kota', 'id_kecamatan', 'id_kelurahan', 'kode_pos', 'alamat', 'status']]];

        $data = $this->global->index($this->model, $request, $fields, $with, $withCount, $relations, $where, $has, $doesntHave);

        return response()->json([
            'data' => $data,
        ]);
    }

    public function updateOrCreate(MemberStore $request)
    {
        $generateId = $request->id ? $request->id : Str::orderedUuid();
        $id = ['id' => $generateId];
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => $request->password,
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
