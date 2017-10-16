<?php

namespace App\Http\Controllers;

use App\FkPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Vk, Auth, DB, Carbon\Carbon, Validator;

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

    public function posts()
    {
        $user = Auth::user();

        $date = '2017-10-13';

        $db_posts = FkPost::where('post_type', 'lfy')
           ->where('date', $date)
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

        return view('fk.posts', ['user'=>$user, 'lastPostDate'=>$date, 'messages'=>$messages]);
    }

    /**
     * Добавление нового поста в базу
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function addPost(Request $request){
        if(!Auth::user()->hasRole('administrator')) return back()->withErrors('Доступ запрещен!');

        $this->validate($request, [
            'link' => 'required|url',
        ], [
            'link.*' => 'Укажите ссылку на пост!',
        ]);

        if(stristr($request->link, 'vk.com') === FALSE || stristr($request->link, FK_WALL) === FALSE) {
            return back()->withErrors('Ссылка должна быть на пост с Ищу.Киев!');
        }

        $post_id = explode(FK_WALL, $request->link);
        $api_response = Vk::api('wall.getById', ['posts'=>FK_WALL_API.$post_id[1]]);
        if ($api_response['status']!='success' || !$api_response['data']) return back()->withErrors('Произошла ошибка при попытке получить запись!');

        $api_post = $api_response['data'][0];

        $fk_post = new FkPost;
        $fk_post->date = Carbon::createFromTimestamp($api_post->date)->format('Y-m-d');
        $fk_post->post_id = $api_post->id;

        $post_type = $fk_post->getPostType($api_post->text);
        if($post_type) $fk_post->post_type = $post_type;
        else return back()->withErrors('Посты данного типа добавлять нельзя!');

        Validator::validate(
            [
                'post_type' => $post_type,
                'post_id'=>$fk_post->post_id],
            [
                'post_type' => 'required',
                'post_id' => 'required|unique:fk_posts'
            ],
            ['post_id.unique' => 'Эта запись уже добавлена ранее!']
        );

        $fk_post->save();

        return back()->with('success',
            'Был добавлен новый пост с "'.$fk_post->getPostTypeText().'" за '.Carbon::parse($fk_post->date)->format('d.m.Y'));

    }
}
