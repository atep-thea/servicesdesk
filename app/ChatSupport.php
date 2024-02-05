<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class ChatSupport extends Model

{

    protected $table = 'chat_support';

 	protected $primaryKey = 'id';

 	protected $fillable = ['id','chat', 'user_id', 'pelayanan_id', 'created_at', 'updated_at'];

    protected $keyType = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function pelayanan()
    {
        return $this->belongsTo('App\Pelayanan', 'pelayanan_id', 'id_');
    }
    public function attachment()
    {
       return $this->hasMany('App\ChatSupportAttachment', 'chat_id','id');
    }

}

