<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'mas_bank';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nama', 'nama_singkat'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function rekening()
    {
        return $this->hasMany(Rekening::class, 'id_bank');
    }
}
