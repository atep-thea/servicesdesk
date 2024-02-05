<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class Organisasi extends Model

{

    protected $table = 'organisasi';

 	protected $primaryKey = 'id_organisasi';

 	protected $fillable = ['induk_organisasi','nama_opd', 'nama_pengelola', 'no_hp_pengelola', 'email', 'status'];

    public $timestamps = false;

    protected $keyType = false;

    public function user()
    {
        return $this->hasMany('App\User','id_organisasi','id_organisasi');
    }

}

