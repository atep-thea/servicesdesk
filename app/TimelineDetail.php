<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimelineDetail extends Model
{
    protected $table='timeline_details';
    protected $primaryKey = "id";
    protected $fillable = ['id','description','type','status','user_id','created_at','update_at','timeline_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
