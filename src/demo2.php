<?php
/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-15
 * Time: 下午12:13
 */

/*
 * /page/:id   = /page/3
 */


function test($a)
{
    return preg_match('/^(\/page\/)[a-z0-9]*(\/user\/)[a-z0-9]*$/i', $a);

}

function match_var($v)
{
    return preg_match('/^(:)[a-z]/i', $v);
}

var_dump(test("/page/3333/user/lgphp"));


$url = "/admin/:username/info/:id";
$url_path = substr($url,1);
$urlinfo = explode("/", $url_path);




$params = array();
$new_path = "/^";
$i=1;
foreach ($urlinfo as $e) {
    $new_path .= "(\/";
    $new_path .= ")";
    if (match_var($e)) {
        $new_path .= "[a-z0-9]*";
        $params[$e] = $i;
    } else {
        $new_path .= "(";
        $new_path .= $e;
        $new_path .= ")";
    }
    $i++;
}
$new_path .= "$/i";


echo $new_path;
$get_url ="/admin/lgphp/info/988";
echo preg_match($new_path, $get_url);

var_dump($params);

$get_url_arr = explode("/",$get_url);




echo $get_url_arr[$params[":id"]];


    preg_match('/[\x{4e00}-\x{9fff}]*/u','我发生的发生2发顺丰',$match);
   print_r($match);

?>