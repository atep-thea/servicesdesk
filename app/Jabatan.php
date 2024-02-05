<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
 	protected $primaryKey = 'id_jabatan';
 	protected $fillable = ['id_jabatan','jabatan'];
    public $timestamps = false;
    protected $keyType = false;
}
