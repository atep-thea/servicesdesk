<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table ='campaigns';
    protected $primaryKey = 'id';
    // protected $primaryKey = 'id';
    public $timestamps 		= false;
}


