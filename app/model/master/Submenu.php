<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    protected $table = 'mas_submenu';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_menu', 'nama', 'warna', 'url', 'id_halaman', 'tipe', 'blank', 'id_kategori_produk'];

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

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
}
