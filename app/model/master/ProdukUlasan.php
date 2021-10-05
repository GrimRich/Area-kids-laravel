<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProdukUlasan extends Model
{
    protected $table = 'mas_produk_ulasan';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_produk', 'id_member', 'deskripsi', 'review', 'gambar', 'id_badge', 'created_at', 'updated_at'];

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
