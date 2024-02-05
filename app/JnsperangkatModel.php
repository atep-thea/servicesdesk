<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JnsPerangkatModel extends Model
{
    protected $table = 'reff_jns_perangkat';
 	protected $primaryKey = 'id_jns_perangkat';
 	protected $fillable = ['id_jns_perangkat','nama_jns_perangkat'];
    public $timestamps = false;
    protected $keyType = false;
}
