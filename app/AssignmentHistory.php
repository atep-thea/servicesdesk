<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentHistory extends Model
{
        protected $table='assignment_history';
        protected $primaryKey = "id";
        protected $fillable = ['id','pelayanan_id','user_id','created_at','updated_at'];
}
