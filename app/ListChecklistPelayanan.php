<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class ListChecklistPelayanan extends Model

{

    protected $table = 'list_checklist_pelayanan';

 	protected $primaryKey = 'id';

 	protected $fillable = ['id','flow_pelayanan_id','pelayanan_id','checklist_id','status','detail','created_at','update_at'];

    protected $keyType = false;
    public $timestamps = false;

    public function checklist()
    {
        return $this->belongsTo('App\Checklist', 'checklist_id', 'id');
    }

}

