<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class ProdukGambar extends Model
{
    protected $table = 'mas_produk_gambar';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_produk', 'gambar'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }
}
