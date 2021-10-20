<?php

namespace App\model\transaksi;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    protected $table = 'trn_alamat';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_member', 'judul_alamat', 'provinsi', 'kota', 'kecamatan', 'kelurahan', 'kode_pos', 'alamat', 'status'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }
}
