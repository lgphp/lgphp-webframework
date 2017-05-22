<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-20
 * Time: 下午10:10
 */
class ChildRouter
{
    private $path;
    private $method;
    private $fn;
    public  function __construct()
    {

    }
    public static  function newChildRouter(string $method,string $path,$fn){
        $childRouterv =  new ChildRouter();
        $childRouterv->setMethod($method);
        $childRouterv->setPath($path);
        $childRouterv->setFn($fn);
        return $childRouterv;
    }

    /**
     * @return mixed
     */
    public function getFn()
    {
        return $this->fn;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = strtoupper($method);
    }

    /**
     * @param mixed $fn
     */
    public function setFn($fn)
    {
        $this->fn = $fn;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

}