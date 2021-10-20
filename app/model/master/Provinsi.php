<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'mas_wilayah_provinsi';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nama'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function kota()
    {
        return $this->hasMany(Kota::class, 'id_provinsi');
    }

    public function kodePos()
    {
        return $this->hasMany(KodePos::class, 'id_provinsi');
    }

    public function memberAlamat()
    {
        return $this->hasMany(MemberAlamat::class, 'id_provinsi');
    }
}
