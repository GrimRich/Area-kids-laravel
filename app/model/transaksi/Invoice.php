<?php

namespace App\model\transaksi;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'trn_invoice';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'no_invoice', 'id_alamat'];

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function alamat()
    {
        return $this->belongsTo(Alamat::class, 'id_alamat');
    }

    public function invoiceDetail()
    {
        return $this->hasMany(InvoiceDetail::class, 'id_invoice');
    }

    public function konfirmasiBayar()
    {
        return $this->hasMany(KonfirmasiBayar::class, 'id_invoice');
    }

    public function metodeBayar()
    {
        return $this->hasMany(MetodeBayar::class, 'id_invoice');
    }
}
