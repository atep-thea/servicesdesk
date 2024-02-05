<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table ='log_transaction';
    protected $primaryKey = 'id';
    // protected $primaryKey = 'id';
    public $timestamps 		= false;
}


