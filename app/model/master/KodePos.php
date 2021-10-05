<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class KodePos extends Model
{
    protected $table = 'mas_wilayah_kode_pos';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = true;

    protected $fillable = ['id', 'id_kota', 'id_kecamatan', 'id_kelurahan', 'id_provinsi', 'kode'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi');
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'id_kota');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }
}
