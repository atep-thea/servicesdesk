<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table ='users';
    protected $primaryKey = 'id';
    // protected $primaryKey = 'id';
    public $timestamps 		= false;
}


