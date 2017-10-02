<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Vk;

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
        if (is_array($role)){
            if (array_search($this->role, $role)===false) return false;
            else return true;
        }
        return $this->role==$role ? true : false;
    }

    public function getFullName(){
        try{
            $api =  Vk::api('users.get')['data'][0];
            return $api->first_name." ".$api->last_name;
        }
        catch (\Exception $e) {
            return  'No name';
        }
    }

    public function getAvatar(){
        try{
            $api =  Vk::api('users.get', ['fields'=>'photo_50'])['data'][0];
            return $api->photo_50;
        }
        catch (\Exception $e) {
            return  'No photo';
        }
    }




}
