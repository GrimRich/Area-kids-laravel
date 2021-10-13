<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class ProdukVarian extends Model
{
    protected $table = 'mas_produk_varian';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_seleksi', 'nama', 'gambar', 'id_produk', 'created_at', 'updated_at'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function produkSeleksi()
    {
        return $this->belongsTo(ProdukSeleksi::class, 'id_seleksi');
    }

    public function produkVarianPilihan()
    {
        return $this->hasMany(ProdukVarianPilihan::class, 'id_produk_varian');
    }
}
