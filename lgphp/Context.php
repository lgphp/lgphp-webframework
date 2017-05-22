<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-21
 * Time: 上午2:14
 */
class Context
{

    private $res;
    private $req;

    /**
     * @return mixed
     */
    public function getRes()
    {
        return $this->res;
    }

    /**
     * @param mixed $res
     */
    public function setRes($res)
    {
        $this->res = $res;
    }

    /**
     * @return mixed
     */
    public function getReq()
    {
        return $this->req;
    }

    /**
     * @param mixed $req
     */
    public function setReq($req)
    {
        $this->req = $req;
    }


}