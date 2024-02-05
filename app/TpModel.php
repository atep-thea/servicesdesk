<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TpModel extends Model
{
    protected $table = 'reff_tipe_permintaan';
 	protected $primaryKey = 'id_tipe';
 	protected $fillable = ['id_tipe','tp_permintaan'];
    public $timestamps = false;
    protected $keyType = false;
}
