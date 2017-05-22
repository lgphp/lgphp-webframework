<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-15
 * Time: 上午1:11
 */
class Request
{

    public $request;
    private $urlparams;

    /**
     * 获取非urlencode-form表单的POST原始数据
     * @return string
     */


    public function __construct($req)
    {
        $this->request = $req;


    }

    public function rawContent()
    {
        $this->request->rawContent();
    }

    public function setUrlParams(array $urlparams)
    {
        $this->urlparams = $urlparams;
    }

    public function urlParams(string $key): string
    {
        $path_info_arr = explode("/", $this->request->server["path_info"]);
        return urldecode($path_info_arr[$this->urlparams[":" . $key]]);

    }

    public function queryParmas(string $key)
    {
        return $this->request->get[$key]??null;
    }

    public function bodyParams(string $key)
    {

        return $this->request->post[$key]??null;
    }

    public function cookie(string $key)
    {
        return $this->request->cookie[$key]??null;
    }

    public function server(string $key)
    {
        return $this->request->server[$key]??null;
    }

    public function files(string $key)
    {
        return $this->request->files[$key]??null;
    }

    public function header(string $key)
    {
        return $this->request->header[$key]??null;
    }
    public  function fd(string $key)
    {
        return $this->request->fd["key"]??null;
    }
}

?>