<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class ProdukVarianPilihan extends Model
{
    protected $table = 'mas_produk_varian_pilihan';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_produk', 'id_seleksi', 'id_produk_varian', 'nama', 'gambar', 'harga', 'harga_coret', 'harga_seller', 'stok', 'tampil', 'created_at', 'updated_at'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function produkVarian()
    {
        return $this->belongsTo(ProdukVarian::class, 'id_produk_varian');
    }

    public function produkSeleksi()
    {
        return $this->belongsTo(ProdukSeleksi::class, 'id_seleksi');
    }
}
