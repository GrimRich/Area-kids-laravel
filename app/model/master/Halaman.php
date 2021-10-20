<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class Halaman extends Model
{
    protected $table = 'mas_halaman';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nama', 'isi', 'url', 'static'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function menu()
    {
        return $this->hasMany(Menu::class, 'id_halaman');
    }

    public function submenu()
    {
        return $this->hasMany(Submenu::class, 'id_halaman');
    }

    public function banner()
    {
        return $this->hasMany(Banner::class, 'id_halaman');
    }
}
