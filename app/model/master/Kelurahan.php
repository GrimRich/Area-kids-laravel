<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'mas_wilayah_kelurahan';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_kecamatan', 'nama'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

    public function kodePos()
    {
        return $this->hasMany(KodePos::class, 'id_provinsi');
    }
}
