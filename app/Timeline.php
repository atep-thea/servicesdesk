<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
        protected $table='timeline';
        protected $primaryKey = "id";
        protected $fillable = ['id','timeline_date','created_at','updated_at','tiket_id'];
        
        public function timelineDetails()
        {
           return $this->hasMany('App\TimelineDetail','timeline_id','id');
        }
}
