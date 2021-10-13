<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class ProdukSeleksi extends Model
{
    protected $table = 'mas_seleksi';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nama'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function produkVarian()
    {
        return $this->hasMany(ProdukVarian::class, 'id_seleksi');
    }

    public function produkVarianPilihan()
    {
        return $this->hasMany(ProdukVarianPilihan::class, 'id_seleksi');
    }
}
