<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $table = 'mas_rekening';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nama', 'no_rekening', 'id_bank'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'id_bank');
    }
}
