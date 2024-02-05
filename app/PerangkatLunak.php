<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerangkatLunak extends Model
{
    protected $table = 'perangkat_lunak';
 	protected $primaryKey = 'id_perangkat';
 	protected $fillable = ['id_organisasi','software', 'lisensi', 'kadaluarsa', 'tgl_pembelian', 'keterangan', 'status', ];
    public $timestamps = false;
    protected $keyType = false;
}
