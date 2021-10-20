<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class ProdukPenjualan extends Model
{
    protected $table = 'mas_produk_penjualan';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_produk', 'total_penjualan', 'produk_terjual', 'dilihat', 'dibatalkan',];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
