<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReffUrgensi extends Model
{
    protected $table = 'reff_urgensi';
 	protected $primaryKey = 'id_urgensi';
 	protected $fillable = ['id_urgensi','urgensi'];
    public $timestamps = false;
    protected $keyType = false;
}
