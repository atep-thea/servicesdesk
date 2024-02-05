<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrgensiModel extends Model
{
    protected $table = 'reff_urgensi';
 	protected $primaryKey = 'id_urgensi';
 	protected $fillable = ['id_urgensi','def_urgensi'];
    public $timestamps = false;
    protected $keyType = false;
}
