<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReffTipePermintaan extends Model
{
    protected $table = 'reff_tipe_permintaan';
 	protected $primaryKey = 'id_tipe';
 	protected $fillable = ['id_tipe','tipe_permintaan'];
    public $timestamps = false;
    protected $keyType = false;
}
