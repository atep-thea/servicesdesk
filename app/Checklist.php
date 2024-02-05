<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class Checklist extends Model

{

    protected $table = 'checklist_pelayanan';

 	protected $primaryKey = 'id';

 	protected $fillable = ['id','checklist_name','flow_pelayanan_id','isDefault','created_at','update_at'];

    public $timestamps = false;

    protected $keyType = false;

    public function list_checklist_detail()
    {
       return $this->hasMany('App\Checklist', 'checklist_id','id');
    }

}

