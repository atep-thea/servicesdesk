<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class InquiryDonatur extends Model
{
    protected $table ='donatur_transaction';
    protected $primaryKey = 'id';
    // protected $primaryKey = 'id';
    public $timestamps 		= false;
}


