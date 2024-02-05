<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
        protected $table='roles';
        protected $primaryKey = "id";
        protected $fillable = ['id','name','display_name','description','created_at','updated_at'];
}
