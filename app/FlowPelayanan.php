<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class FlowPelayanan extends Model

{

    protected $table = 'flow_pelayanan';

 	protected $primaryKey = 'id';

 	protected $fillable = ['id','name','status','jns_pelayanan_id','koordinator_id','stage','user_koordinator_id'];

    public $timestamps = false;

    protected $keyType = false;

    public function checklist()
    {
       return $this->hasMany('App\Checklist', 'flow_pelayanan_id','id');
    }

    public function user_penanggung_jawab()
    {
       return $this->belongsTo('App\User','user_koordinator_id','id');
    }

    public function team()
    {
       return $this->belongsTo('App\Team','koordinator_id','id_team');
    }

}

