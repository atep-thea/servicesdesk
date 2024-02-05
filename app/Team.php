<?php



namespace App;

use App\User;

use Illuminate\Database\Eloquent\Model;



class Team extends Model

{

    protected $table = 'team';

 	protected $primaryKey = 'id_team';

 	protected $fillable = ['id_team','name_team'];

    public $timestamps = false;

    protected $keyType = false;

    public function member()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            User::class,
            'team_user',
            'team_id',
            'user_id'           
        )->withPivot('leader');
    }

}

