<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'mas_menu';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nama', 'warna', 'url', 'id_halaman', 'tipe', 'blank', 'id_kategori_produk', 'submenu', 'is_footer', 'tipe_footer'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function halaman()
    {
        return $this->belongsTo(Halaman::class, 'id_halaman');
    }

    public function kategoriProduk()
    {
        return $this->belongsTo(ProdukKategori::class, 'id_kategori');
    }
}
