<?php
/**
 * Created by PhpStorm.
 * User: Валерий
 * Date: 16.09.2017
 * Time: 14:33
 */

namespace app\Facades;
use Illuminate\Support\Facades\Facade;


class VkApiFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'VkApi'; }

}