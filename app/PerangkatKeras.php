<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerangkatKeras extends Model
{
    protected $table = 'perangkat_keras';
 	protected $primaryKey = 'id_perangkat';
 	protected $fillable = ['id_organisasi','jns_perangkat', 'merek', 'nama_perangkat', 'model', 'phone', 'tgl_pembelian', 'serial_number','aset_number', 'deskripsi', 'status',  ];
    public $timestamps = false;
    protected $keyType = false;
}
