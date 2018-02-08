<?php
/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17/2/20
 * Time: 22:13
 */


//phpinfo();



//header("content-type:application/json");// 尽量不要用text/json 某些浏览器会不兼容
//$json='{"price":200,"midle":150,"low":100}';//注意外面的单引号
//echo $json;

phpinfo();


exit();

trait DemoTrait{
    private $str ;
    public function __construct(?string $s)
    {
        $this->str = $s;
    }

    /**
     * @return null|string
     */
    public function getStr(): ?string
    {
        return $this->str;
    }
}


class  C{
    use DemoTrait;

}


$c = new C('你好');
var_dump($c->getStr());

$arr = new Exception();

echo  json_encode($arr);




//
//$v=array("h"=>"300" , "m"=>"280" , "l"=>"250");
//$json=json_encode($v);
//header("content-type:application/json");
//echo $json;