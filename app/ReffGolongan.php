<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class ReffGolongan extends Model

{

    protected $table = 'reff_golongan';

 	protected $primaryKey = 'id';

 	protected $fillable = ['id','name'];

    public $timestamps = false;

    protected $keyType = false;

}

