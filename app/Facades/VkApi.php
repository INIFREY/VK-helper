<?php
/**
 * Created by PhpStorm.
 * User: Валерий
 * Date: 16.09.2017
 * Time: 14:29
 */

namespace app\Facades;
use Auth;



/**
 * @mixin \Eloquent
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class VkApi
{
    public function __construct(){
        $this->user = Auth::user();
    }

    public function api($method, $parameters=[], $token=false){
        $result = array();
        $parameters = http_build_query($parameters);
        if (!$token) $token = $this->user->token;

        $response = json_decode(file_get_contents('https://api.vk.com/method/'.$method.'?'.$parameters.'&v=5.68&access_token='.$token));

        // Если всё ок
        if (isset($response->response)){
            $result['status'] = 'success';
            $result['data'] = $response->response;

        } elseif (isset($response->error)){
            // Случилась ошибка
            $result['status'] = 'error';
            $result['data'] = $response->error;

        } else{
            $result['status'] = 'error';
            $result['data'] = "Неизвестная ошибка";
        }

        return $result;
    }

}