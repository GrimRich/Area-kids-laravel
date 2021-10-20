<?php

namespace App\model\transaksi;

use App\model\master\Produk as MasterProduk;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'trn_produk';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nama', 'nama_variant', 'nama_variant_pilihan', 'stok_variant_pilihan', 'deskripsi', 'kategori', 'gambar_utama', 'stok', 'berat', 'harga', 'harga_coret', 'harga_seller', 'diskon', 'alias', 'tags', 'id_produk'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function produk()
    {
        return $this->belongsTo(MasterProduk::class, 'id_produk');
    }

    public function invoiceDetail()
    {
        return $this->hasMany(InvoiceDetail::class, 'id_produk');
    }
}
