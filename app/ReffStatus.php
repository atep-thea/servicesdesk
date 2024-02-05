<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReffStatus extends Model
{
    protected $table = 'reff_status';
 	protected $primaryKey = 'id_status';
 	protected $fillable = ['id_status','status_name'];
    public $timestamps = false;
    protected $keyType = false;
}
