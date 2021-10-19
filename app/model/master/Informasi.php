<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    protected $table = 'mas_informasi';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nama', 'logo', 'kontak', 'email', 'facebook', 'instagram', 'youtube', 'twitter', 'alamat', 'shopee', 'tokopedia', 'bukalapak', 'lazada'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }
}
