<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'mas_banner';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'link', 'id_produk', 'id_produk_kategori', 'gambar', 'tampil', 'tipe', 'id_halaman'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function produkKategori()
    {
        return $this->belongsTo(ProdukKategori::class, 'id_produk_kategori');
    }

    public function halaman()
    {
        return $this->belongsTo(Halaman::class, 'id_halaman');
    }
}
