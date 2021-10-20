<?php

namespace App\model\transaksi;

use Illuminate\Database\Eloquent\Model;

class MetodeBayar extends Model
{
    protected $table = 'trn_metode_bayar';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_invoice', 'bank', 'nama', 'no_rekening'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'id_invoice');
    }
}
