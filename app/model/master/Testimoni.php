<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $table = 'mas_testimoni';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nama', 'gambar', 'deskripsi'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }
}
