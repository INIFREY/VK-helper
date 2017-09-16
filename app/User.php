<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vk_id', 'token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Определяет, принадлежит ли пользователю данная роль
     * @param string $role Роль
     * @return bool
     */
    public function hasRole($role){
        $result = DB::table('roles')->where([
            ['role', '=', $role],
            ['user_id', '=', $this->id],
        ])->count();

        return $result>0 ? true : false;
    }

    /**
     * Вернет роль пользователя
     * @return mixed
     */
    public function getRole(){
        return DB::table('roles')->where('user_id', $this->id)->value('role');
    }

}
