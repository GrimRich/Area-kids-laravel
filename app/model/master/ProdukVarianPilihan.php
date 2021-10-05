<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class ProdukVarianPilihan extends Model
{
    protected $table = 'mas_produk_varian_pilihan';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_produk_varian', 'nama', 'harga', 'harga_seller', 'stok'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }
}
