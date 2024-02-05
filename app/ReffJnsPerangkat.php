<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReffJnsPerangkat extends Model
{
    protected $table = 'reff_jns_perangkat';
 	protected $primaryKey = 'id_perangkat';
 	protected $fillable = ['id_perangkat','id_organisasi', 'id_jns_perangkat', 'merek', 'nama_perangkat', 'model','phone','tgl_pembelian','tgl_akhir_garansi','serial_number','aset_number','deskripsi','status'];
    public $timestamps = false;
    protected $keyType = false;
}
