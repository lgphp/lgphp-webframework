<?php
/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-14
 * Time: 上午1:51
 */

class A{
    public function saya()
    {
        echo "hello A";
    }
}

class B extends A{
    public function say(){
        echo "hello B";
    }
}


function testB($str, $fn)
{
    echo $str;
    $fn(new A());
}

testB("test",function (A $a){
    //$a->saya();
});




  $teststr = "/";
  echo substr($teststr,0,-1);

  $arr=array();

  print_r($arr);

$file_path = pathinfo('/www/htdocs/your_image.jpg');

print_r($file_path);


?>

