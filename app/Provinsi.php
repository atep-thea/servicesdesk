<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table ='provinces';
   
    protected $primaryKey = 'id';

    public function kota(){
        return $this->hasMany('App\Models\Kota','province_id','id');
    }
}
