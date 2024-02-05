<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subsubkategori extends Model
{
    protected $table = 'reff_ssjns_pelayanan';
 	protected $primaryKey = 'id_ssjns';
 	protected $fillable = ['id_ssjns','id_sjns','id_pelayanan','ssjns'];
    public $timestamps = false;
    protected $keyType = false;
}
