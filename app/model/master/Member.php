<?php

namespace App\model\master;

use App\model\transaksi\Alamat;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'mas_member';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nama', 'email', 'password', 'no_hp'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function memberAlamat()
    {
        return $this->hasMany(MemberAlamat::class, 'id_member');
    }

    public function produkUlasan()
    {
        return $this->hasMany(ProdukUlasan::class, 'id_member');
    }

    public function alamat()
    {
        return $this->hasMany(Alamat::class, 'id_member');
    }
}
