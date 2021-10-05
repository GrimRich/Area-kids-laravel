<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table = 'mas_wilayah_kota';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_provinsi', 'nama'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi');
    }

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'id_kota');
    }

    public function kodePos()
    {
        return $this->hasMany(KodePos::class, 'id_provinsi');
    }
}
