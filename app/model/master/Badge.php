<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $table = 'mas_badge';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nama'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function produkUlasan()
    {
        return $this->hasMany(ProdukUlasan::class, 'id_badge');
    }
}
