<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Vk;
use Auth;
use DB;
use Carbon\Carbon;

class FindKievController extends Controller
{
    /**
     *  Ищу тебя
     */

    public function __construct()
    {
        define('FK_WALL',  'wall-67505812_'); // Ссылка на стену Ищу.Киев
        define('FK_WALL_API',  '-67505812_');
    }

    public function lookingForYou()
    {
        $user = Auth::user();

        $date = '2017-10-02';

        $db_posts = DB::table('fk_posts')
            ->select(DB::raw("post_id"))
            ->where('post_type', 'lfy')->where('date', $date)
            ->orderBy('date', 'desc')->get();

        $api_posts_links=""; // Ссылки на записи со стены, для передачи по API
        foreach ($db_posts as $row) $api_posts_links.= FK_WALL_API.$row->post_id.=',';

        $posts = Vk::api('wall.getById', ['posts'=>$api_posts_links]);

        $messages = array(); // Все сообщения с постов

        foreach ($posts['data'] as $one) {
            $temp = preg_split("/\\n( |)\\n/", $one->text);
            array_shift($temp); // Удаляем первый элемент
            $messages = array_merge($messages,  $temp);
        }

        foreach ($messages as &$message){
            $message = trim($message);
        }

        return view('fk.lfy', ['user'=>$user, 'lastPostDate'=>$date, 'messages'=>$messages]);
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function lookingForYouAddPost(Request $request){
        if(!Auth::user()->hasRole('administrator')) return back()->withErrors('Доступ запрещен!');

        $this->validate($request, [
            'date' => 'required|date',
            'link' => 'required|url',
        ], [
            'link.*' => 'Укажите ссылку на пост!',
        ]);

        if(stristr($request->link, 'vk.com') === FALSE || stristr($request->link, FK_WALL) === FALSE) {
            return back()->withErrors('Ссылка должна быть на пост с Ищу.Киев!');
        }

        // TODO:: Проверка, нужный ли пост тут (Ищу тебя)

        $linkArr = explode(FK_WALL, $request->link);

        DB::table('fk_posts')->insert(
            [
                'post_id' => $linkArr[1],
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'post_type'=>'lfy'
            ]
        );

        return back();

    }
}
