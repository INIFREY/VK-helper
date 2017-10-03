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
    public function lookingForYou()
    {
        $user = Auth::user();
        $lastPost = DB::table('looking_for_you')->orderBy('id', 'desc')->first();
        $post = Vk::api('wall.getById', ['posts'=>'-'.$lastPost->post_id]);
        $messages = explode("\n\n", $post['data'][0]->text);
        foreach ($messages as &$message){
            $message = trim($message);
        }
        array_shift($messages);

        return view('fk.lfy', ['user'=>$user, 'lastPostDate'=>$lastPost->date, 'messages'=>$messages]);
    }

    public function lookingForYouAddPost(Request $request){
        if(!Auth::user()->hasRole('administrator')) return back()->withErrors('Доступ запрещен!');

        $this->validate($request, [
            'date' => 'required|date',
            'link' => 'required|url',
        ], [
            'link.*' => 'Укажите ссылку на пост!',
        ]);

        if(stristr($request->link, 'vk.com') === FALSE || stristr($request->link, 'wall-67505812') === FALSE) {
            return back()->withErrors('Ссылка должна быть на пост с Ищу.Киев!');
        }

        $linkArr = explode('wall-', $request->link);

        DB::table('looking_for_you')->insert(
            ['post_id' => $linkArr[1], 'date' => Carbon::parse($request->date)->format('Y-m-d')]
        );

        return back();

    }
}
