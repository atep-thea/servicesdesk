<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefInfraModel extends Model
{
    protected $table = 'reff_infrastruktur';
 	protected $primaryKey = 'id_infrastruktur';
 	protected $fillable = ['id_infrastruktur','infrastruktur'];
    public $timestamps = false;
    protected $keyType = false;
}
