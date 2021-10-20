<?php

namespace App\model\master;

use App\model\transaksi\Produk as TransaksiProduk;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'mas_produk';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_kategori', 'nama', 'deskripsi', 'gambar_utama', 'stok', 'berat', 'harga', 'harga_coret', 'diskon', 'alias', 'tags', 'panduan_ukuran', 'harga_min', 'harga_max', 'tampil', 'created_at', 'updated_at', 'nama_variasi'];

    protected $appends = array('option_one', 'option_two');

    public function getOptionOneAttribute()
    {
        return count(explode(",", $this->nama_variasi)) > 0 ? explode(",", $this->nama_variasi)[0] : '';
    }

    public function getOptionTwoAttribute()
    {
        return count(explode(",", $this->nama_variasi)) > 1 ? explode(",", $this->nama_variasi)[1] : '';
    }

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

    public function produkVarianPilihan()
    {
        return $this->hasMany(ProdukVarianPilihan::class, 'id_produk');
    }

    public function produkUlasan()
    {
        return $this->hasMany(ProdukUlasan::class, 'id_produk');
    }

    public function banner()
    {
        return $this->hasMany(Banner::class, 'id_produk');
    }

    public function produkPenjualan()
    {
        return $this->hasMany(ProdukPenjualan::class, 'id_produk');
    }

    public function produkTransaksi()
    {
        return $this->hasMany(TransaksiProduk::class, 'id_produk');
    }
}
