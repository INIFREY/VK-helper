<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Vk;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class VkController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $array = [];
        $t = Vk::api('groups.search', ['q'=>'Создать сайт', 'count'=>1]);
        foreach ($t['data']->items as $value) {
            array_push($array, $value->id);
        }

       // dd($array);
        return view('vk.index', ['user'=>$user]);
    }

    public function auth(Request $request)
    {
        $client_id = '5567992'; // Идентификатор Вашего приложения.
        $redirect_uri = 'http://helpvk.kl.com.ua/auth'; // Адрес, на который будет передан code
        $client_secret = 'ZZkEb7JalwZe6oU8mXcd'; // Защищенный ключ Вашего приложения

        if ($request->code){
            $client = new Client();
            try {
                $response = $client->request('GET', 'https://oauth.vk.com/access_token?client_id='.$client_id.'&client_secret='.$client_secret.'&redirect_uri='.$redirect_uri.'&code='.$request->code);

                // Если всё ок
                $data = json_decode($response->getBody());
                $user = User::updateOrCreate(
                    ['vk_id' => $data->user_id],
                    ['token' => $data->access_token]
                );
                Auth::login($user);
                return redirect('/');
            } catch (ClientException $e) {
                // Случилась ошибка при попытке получения token
                $error = json_decode($e->getResponse()->getBody());
                echo "Произошла ошибка: <br>";
                echo($error->error_description);
                echo "<br><a href='".url('/auth')."'>Попробовать ещё раз</a>";
                exit();
            }


        }
        return redirect("https://oauth.vk.com/authorize?client_id=$client_id&redirect_uri=$redirect_uri");
    }

}
