<?php



namespace App;



use Illuminate\Database\Eloquent\Model;
use App\AgentTaskAttachment;



class PelayananAgentTask extends Model

{

    protected $table = 'pelayanan_agent_task';

 	protected $primaryKey = 'id';

 	protected $fillable = ['id','user_agent', 'task_report', 'pelayanan_id','status','stage','created_at', 'updated_at','final_solution'];

    protected $keyType = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_agent', 'id');
    }
    public function pelayanan()
    {
        return $this->belongsTo('App\Pelayanan', 'pelayanan_id', 'id_');
    }
    public function attachment()
    {
        return $this->hasMany('App\AgentTaskAttachment','agent_task_id','id');
    }
    public function attachmentFinalSolution()
    {
        return $this->hasOne(AgentTaskAttachment::class,'agent_task_id','id');
    }
    public function flow()
    {
        return $this->belongsTo('App\FlowPelayanan', 'stage', 'id');
    }

}

