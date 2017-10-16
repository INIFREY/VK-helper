<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FkPost extends Model
{
    protected $table = 'fk_posts';
    public $timestamps = false;


    /**
     * Определяет тип поста
     *
     * @param string $text Текст поста
     * @return bool|string Тип поста или ложь
     */
    public function getPostType($text){
        $array = explode("\n", $text);
        if ((@stristr($array[0], '"ИЩУ ТЕБЯ":') || @stristr($array[1], '"ИЩУ ТЕБЯ":')) &&
            (@stristr($array[0], '#ИщуКиев_ищутебя') || @stristr($array[1], '#ИщуКиев_ищутебя'))
        ) return "lfy";
        else return false;
    }

    /**
     * Возвращает текстовый вариант типа поста
     * @param string $type Тип поста ('lfy')
     * @return string Тип поста (Ищу тебя)
     */
    public function getPostTypeText($type=null){
        $type?:$type=$this->post_type;

        switch ($type){
            case 'lfy': return "Ищу тебя";
            default: return "";
        }
    }


}
