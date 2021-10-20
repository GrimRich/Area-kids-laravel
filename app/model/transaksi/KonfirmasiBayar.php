<?php

namespace App\model\transaksi;

use App\model\master\Rekening;
use Illuminate\Database\Eloquent\Model;

class KonfirmasiBayar extends Model
{
    protected $table = 'trn_konfirmasi_bayar';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_invoice', 'nama_pengirim', 'no_rekening_pengirim', 'id_rekening', 'bukti_transfer', 'status'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'id_invoice');
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'id_rekening');
    }
}
