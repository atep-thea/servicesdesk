<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReffSjnsPelayanan extends Model
{
    protected $table = 'reff_sjns_pelayanan';
 	protected $primaryKey = 'id_sjns_pelayanan';
 	protected $fillable = ['id_sjns_pelayanan','id_pelayanan','jenis_pelayanan'];
    public $timestamps = false;
    protected $keyType = false;
}
