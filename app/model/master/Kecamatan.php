<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'mas_wilayah_kecamatan';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_kota', 'nama'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'id_kota');
    }

    public function kelurahan()
    {
        return $this->HasMany(Kelurahan::class, 'id_kecamatan');
    }

    public function kodePos()
    {
        return $this->hasMany(KodePos::class, 'id_kecamatan');
    }
}
