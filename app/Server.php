<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $table = 'infra_server';
 	protected $primaryKey = 'id_server';
 	protected $fillable = ['id_infrastruktur','nama_perangkat', 'model', 'merek', 'lisensi', 'nomer_serial', 'nomer_aset', 'ip_manajemen', 'no_rak','status'];
    public $timestamps = false;
    protected $keyType = false;
}
