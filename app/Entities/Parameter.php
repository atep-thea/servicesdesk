<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $table ='parameters';
    protected $primaryKey = 'id';
    // protected $primaryKey = 'id';
    public $timestamps 		= false;
}


