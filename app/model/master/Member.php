<?php

namespace App\model\master;

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
}
