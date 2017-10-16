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
        elseif ((@stristr($array[0], '"КЛУБ ОДИНОКИХ СЕРДЕЦ":') || @stristr($array[1], '"КЛУБ ОДИНОКИХ СЕРДЕЦ":')) &&
            (@stristr($array[0], '#ИщуКиев_кос') || @stristr($array[1], '#ИщуКиев_кос'))
        ) return "kos";
        elseif ((@stristr($array[0], '"ПОИСК НОВЫХ ДРУЗЕЙ":') || @stristr($array[1], '"ПОИСК НОВЫХ ДРУЗЕЙ":')) &&
            (@stristr($array[0], '#ИщуКиев_пнд') || @stristr($array[1], '#ИщуКиев_пнд'))
        ) return "pnd";
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
            case 'kos': return "Клуб одиноких сердец";
            case 'pnd': return "Поиск новых друзей";
            default: return "";
        }
    }


}
