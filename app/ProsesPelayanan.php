<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProsesPelayanan extends Model
{
   protected $table = 'proses_jenis_pelayanan';
   protected $primaryKey = 'id';
   protected $fillable = ['id_team','id_jenis_pelayanan','queue'];
   protected $keyType = false;

}
