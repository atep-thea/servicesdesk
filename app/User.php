<?php

namespace App;

use App\Team;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;

    use EntrustUserTrait;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            if ($user->facebook_user_id) {
                $user->roles()->attach(2);
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $keyType = false;

    protected $fillable = [
        'id', 'nama_depan', 'nama_belakang', 'id_organisasi', 'role_user', 'id_jabatan', 'name', 'email', 'password', 'phone', 'foto', 'remember_token', 'identity_file',
        'jenis_kelamin', 'notifikasi', 'id_team', 'status', 'decrypt_pass', 'jbt', 'forget_token', 'golongan_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','decrypt_pass'
    ];

    public function firstName()
    {
        $name = explode(" ", $this->name);
        return $name[0];
    }

    public function getProfpicUrlAttribute($value)
    {
        if ($value) return str_replace("^", "?", $value);
    }

    public function golongan()
    {
        return $this->belongsTo('App\ReffGolongan', 'golongan_id', 'id');
    }

    public function role_user()
    {
        return $this->belongsTo('App\RoleUser', 'role_user', 'display_name');
    }

    public function org()
    {
        return $this->belongsTo('App\Organisasi', 'id_organisasi', 'id_organisasi');
    }

    public function jabatan()
    {
        return $this->belongsTo('App\Jabatan', 'id_jabatan', 'id_jabatan');
    }

    public function jnsPelayanan()
    {
        return $this->hasMany('App\JnspelayananModel', 'penanggung_jawab_id', 'id');
    }

    public function team()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Team::class,
            'team_user',
            'user_id',
            'team_id'
        );
    }
}
