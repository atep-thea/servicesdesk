<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\JnspelayananModel;

class Pelayanan extends Model
{
    protected $table = 'pelayanan';
    protected $primaryKey = 'id_';
    protected $fillable = ['kd_tiket', 'id_opd', 'judul', 'survey_rate', 'id_team', 'contact_person', 'file_surat_dinas', 'deskripsi', 'jns_pelayanan', 'sub_jns_pelayanan', 'catatan_khusus', 'tipe_permintaan', 'urgensi', 'jns_insiden', 'tgl_pelaporan', 'tgl_kirim_sla', 'tgl_update', 'id_agen', 'id_pelapor', 'lampiran', 'status', 'lampiran_balasan', 'komen_slaba', 'jwb_komen_slaba', 'file_ba', 'sla_bls', 'ba_bls', 'desk_balasan', 'stage', 'status_ba_agent'];
    public $timestamps = false;
    protected $keyType = false;

    public function pelapor()
    {
        return $this->belongsTo('App\User', 'id_pelapor', 'id');
    }
    public function organisasi()
    {
        return $this->belongsTo('App\Organisasi', 'id_opd', 'id_organisasi');
    }
    public function team()
    {
        return $this->belongsTo('App\Team', 'id_team', 'id_team');
    }

    public function jns_pelayanan()
    {
        return $this->belongsTo(JnspelayananModel::class, 'jns_pelayanan', 'id_pelayanan');
    }

    public function jenis_pelayanan()
    {
        return $this->belongsTo(JnspelayananModel::class, 'jns_pelayanan', 'id_pelayanan');
    }

    public function agent()
    {
        return $this->belongsTo('App\User', 'id_agen', 'id');
    }

    public function flow_pelayanan()
    {
        return $this->belongsTo('App\FlowPelayanan', 'stage', 'id');
    }

    public function timelines()
    {
        return $this->hasMany('App\Timeline', 'tiket_id', 'id_');
    }

    public function chat_support()
    {
        return $this->hasMany('App\ChatSupport', 'pelayanan_id', 'id_');
    }
    public function attachment()
    {
        return $this->hasMany('App\ChatSupportAttachment', 'pelayanan_id', 'id_');
    }

    public function agent_task()
    {
        return $this->hasMany('App\PelayananAgentTask', 'pelayanan_id', 'id_');
    }

  

    public function agent_task_last()
    {
        return $this->hasOne('App\PelayananAgentTask', 'pelayanan_id', 'id_')->latest();
    }

    public function agent_progress_attachment()
    {
        return $this->hasMany('App\AgentTaskAttachment', 'pelayanan_id', 'id_');
    }

    public function assignment_history()
    {
        return $this->hasOne('App\AssignmentHistory', 'pelayanan_id', 'id_');
    }
}
