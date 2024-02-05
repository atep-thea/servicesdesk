<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'costumers';
 	protected $primaryKey = 'id';
 	protected $fillable = ['id','name','gender','email','created_at','update_at'];
    public $timestamps = false;
    protected $keyType = false;
}
