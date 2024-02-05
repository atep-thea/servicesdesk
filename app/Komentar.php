<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentar';
 	protected $primaryKey = 'id_komen';
 	protected $fillable = ['id_komen','id_pelayanan','id_user','tgl_komen','komentar'];
    public $timestamps = false;
    protected $keyType = false;
}
