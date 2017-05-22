<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-20
 * Time: 下午11:09
 */
abstract class Handler
{
    protected $routers;

    public function __construct(array $method_and_path = array("GET"=>"/"))
    {
        $this->routers = $method_and_path;
    }

    /**
     * @return array
     */
     function getRouters(): array {
            return $this->routers;
    }

    function setRouters(){
            return;
    }

    abstract function callback();
}