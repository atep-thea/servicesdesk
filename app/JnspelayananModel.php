<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class JnspelayananModel extends Model

{

    protected $table = 'reff_jns_pelayanan';

 	protected $primaryKey = 'id_pelayanan';

 	protected $fillable = ['id_pelayanan','pelayanan','penanggung_jawab_id','koordinator_penanggung_jawab_id','persyaratan'];

    public $timestamps = false;

    protected $keyType = false;

    public function flowPelayanan()
    {
       return $this->hasMany('App\FlowPelayanan', 'jns_pelayanan_id', 'id_pelayanan');
    }

    public function pelayanan()
    {
       return $this->hasMany('App\Pelayanan', 'jns_pelayanan', 'id_pelayanan');
    }

    public function penanggungJawabEselon3()
    {
       return $this->belongsTo('App\User', 'penanggung_jawab_id', 'id');
    }

    public function koordinatorAgen()
    {
       return $this->belongsTo('App\User', 'koordinator_penanggung_jawab_id', 'id');
    }
}

