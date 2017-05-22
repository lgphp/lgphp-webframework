<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-20
 * Time: 下午10:24
 */
class Util
{
    //第一个是原串,第二个是 部份串
    static  function startWith(string $str, $needle) {

        return strpos($str, $needle) === 0;

    }

//第一个是原串,第二个是 部份串
    static  function endWith(string $src, $needle) {

        $length = strlen($needle);
        if($length == 0)
        {
            return true;
        }
        return (substr($src, -$length) === $needle);
    }

}