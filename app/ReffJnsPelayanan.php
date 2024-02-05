<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class ReffJnsPelayanan extends Model

{

    protected $table = 'reff_jns_pelayanan';

 	protected $primaryKey = 'id_pelayanan';

 	protected $fillable = ['id_pelayanan','pelayanan','penanggung_jawab_id','koordinator_penanggung_jawab_id','persyaratan'];

    public $timestamps = false;

    protected $keyType = false;

}

