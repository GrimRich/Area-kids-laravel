<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class MemberAlamat extends Model
{
    protected $table = 'mas_member_alamat';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'id_member', 'judul_alamat', 'id_provinsi', 'id_kota', 'id_kecamatan', 'id_kelurahan', 'kode_pos', 'alamat', 'status'];

    protected $appends = array('nama_provinsi', 'nama_kota', 'nama_kecamatan', 'nama_kelurahan', 'nama_kode_pos');

    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->where('id', '=', $this->getAttribute('id'));

        return $query;
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi');
    }
    public function kota()
    {
        return $this->belongsTo(Kota::class, 'id_kota');
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }
    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }
    public function kodePos()
    {
        return $this->belongsTo(KodePos::class, 'kode_pos');
    }

    public function getNamaProvinsiAttribute()
    {
        return $this->provinsi->nama;
    }

    public function getNamaKotaAttribute()
    {
        return $this->kota->nama;
    }

    public function getNamaKecamatanAttribute()
    {
        return $this->kecamatan->nama;
    }

    public function getNamaKelurahanAttribute()
    {
        return $this->kelurahan->nama;
    }

    public function getNamaKodePosAttribute()
    {
        return $this->kodePos->kode;
    }
}
