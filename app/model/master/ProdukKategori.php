<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProdukKategori extends Model
{
    protected $table = 'mas_produk_kategori';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nama'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori');
    }
}
