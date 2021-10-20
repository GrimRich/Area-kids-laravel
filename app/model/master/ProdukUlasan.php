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
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    public function id_badge()
    {
        return $this->belongsTo(Badge::class, 'id_badge');
    }
}
