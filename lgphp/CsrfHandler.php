<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-21
 * Time: 下午1:37
 */


class Csrf extends Handler
{
    private $header_key = "X_CSRF_TOKEN";
    private $forbidden_methods = array("POST", "PUT", "DELETE");
    private $form_key = "authenticity_token";
    private $errmsg = "禁止访问";
    private $allow_routers;
    public function __construct(string $header_key, string $form_key, string $errmsg,
                                array $allow_routers = array("POST" => "/"))
    {

        parent::__construct(array());
        $this->header_key = $header_key;
        $this->form_key = $form_key;
        $this->errmsg = $errmsg;
        $this->allow_routers = $allow_routers;
    }


    function setRouters()
    {
        $router_handlers = RouteHandler::getRouterHandlers();
        $forbidden_routers = array_filter($router_handlers, function ($v)  {
            return !in_array($v, $this->allow_routers);
        }); //两个数组的差，取得禁止的路由
        $this->routers = $forbidden_routers;
    }


    function callback()
    {
        // TODO: Implement callback() method.
        return function (Request $req, Response $res) : bool {
            $method = strtoupper($req->server("request_method"));
            if (!in_array($method, $this->forbidden_methods)) {
                   return $res->next();
            }

            $csrf_token = uniqid();//以后升级这个id
            if (is_null(Session::getSession("csrf"))) {

                Session::setSession("csrf", $csrf_token);
            }
            $submitted = "nothing";
            if (!empty($req->header($this->header_key))) {
                $submitted = $req->header($this->header_key);
            } elseif (!empty($req->bodyParams($this->form_key))) {
                $submitted = $req->bodyParams($this->form_key);
            } elseif (!empty($req->fd($this->form_key))) {
                $submitted = $req->fd($this->form_key);
            }

            $current_token = Session::getSession("csrf");
            if ($current_token === $submitted) {
                return $res->next();
            } else {
                $res->status(403);
                $res->write($this->errmsg);
                echo $this->errmsg;  //以后改成日志输出；

            }
            return $res->die();
        };
    }




}