<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vk;
use Auth;
use DB;

class FindKievController extends Controller
{
    /**
     *  Ищу тебя
     */
    public function lookingForYou()
    {
        $user = Auth::user();
        $lastPost = DB::table('looking_for_you')->first();
        $post = Vk::api('wall.getById', ['posts'=>'-'.$lastPost->post_id]);
        $messages = explode("\n\n", $post['data'][0]->text);
        foreach ($messages as &$message){
            $message = trim($message);
        }
        array_shift($messages);

        return view('fk.lfy', ['user'=>$user, 'lastPostDate'=>$lastPost->date, 'messages'=>$messages]);
    }
}
