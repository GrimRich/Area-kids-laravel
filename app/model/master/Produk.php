<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'mas_produk';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_kategori', 'nama', 'deskripsi', 'gambar_utama', 'stok', 'berat', 'harga', 'harga_coret', 'diskon', 'alias', 'tags', 'panduan_ukuran', 'harga_min', 'harga_max', 'tampil', 'created_at', 'updated_at'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function produkKategori()
    {
        return $this->belongsTo(ProdukKategori::class, 'id_kategori');
    }

    public function produkGambar()
    {
        return $this->hasMany(ProdukGambar::class, 'id_produk');
    }

    public function produkVarian()
    {
        return $this->hasMany(ProdukVarian::class, 'id_produk');
    }

    public function produkUlasan()
    {
        return $this->hasMany(ProdukUlasan::class, 'id_produk');
    }
}
