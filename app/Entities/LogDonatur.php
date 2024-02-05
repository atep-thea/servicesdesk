<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class LogDonatur extends Model
{
    protected $table ='log_donatur_zains';
    protected $primaryKey = 'id';
    // protected $primaryKey = 'id';
    public $timestamps 		= false;
}


