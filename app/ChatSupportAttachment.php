<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class ChatSupportAttachment extends Model

{

    protected $table = 'chat_support_attachment';

 	protected $primaryKey = 'id';

 	protected $fillable = ['id','chat_id','user_id', 'pelayanan_id','filename', 'created_at', 'updated_at'];

    protected $keyType = false;

    public function pelayanan()
    {
        return $this->belongsTo('App\Pelayanan', 'pelayanan_id', 'id_');
    }
    public function chat()
    {
        return $this->belongsTo('App\ChatSupport', 'chat_Id', 'id');
    }

}

