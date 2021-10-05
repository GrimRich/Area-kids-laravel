<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class ProdukVarian extends Model
{
    protected $table = 'mas_produk_varian';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nama', 'id_produk'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }
}
