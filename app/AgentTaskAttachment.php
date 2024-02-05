<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class AgentTaskAttachment extends Model

{

    protected $table = 'agent_task_attachment';

 	protected $primaryKey = 'id';

 	protected $fillable = ['id','agent_task_id', 'pelayanan_id', 'filename','created_at', 'updated_at','is_ba'];

    protected $keyType = false;

    public function agent_task()
    {
        return $this->belongsTo('App\PelayananAgentTask', 'agent_task_id', 'id');
    }
    public function pelayanan()
    {
        return $this->belongsTo('App\Pelayanan', 'pelayanan_id', 'id_');
    }


}

