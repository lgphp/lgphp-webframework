<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-14
 * Time: 上午1:38
 */
class Response
{
    public $response;
    public $template_engine;

    public function __construct($res)
    {
        $this->response = $res;
    }

    public function redirect(string $url)
    {

        $this->response->header("location", $url);
        $this->response->status(302);
        $this->response->end();

    }

    public function sendJson(string $jsonString)
    {
        $this->setMimeType("application/json");
        $this->send($jsonString);

    }

    public function end(string $html = "")
    {
        $this->response->end($html);
        return false;
    }

    public function header(string $key, string $value)
    {
        $this->response->header($key, $value);
    }

    public function setMimeType(string $mimetype)
    {
        $this->header("Content-Type", $mimetype);
    }

    public function write(string $html = "")
    {

        $this->response->write($html);
    }

    public function status(int $code)
    {
        $this->response->status($code);
    }

    public function send(string $html = "")
    {
        $this->response->write($html);
    }

    public function cookie($key, $value, $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = false)
    {
        $this->response->cookie($key, $value, $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = false);
    }

    public final function next()
    {
        return true;
    }

    public final function die()
    {
        return false;
    }


    /**
     * 设置Http压缩格式
     * @param int $level
     */
    function gzip($level = 1)
    {
        $this->response->gzip($level);
    }

    /**
     * 发送静态文件
     * @param string $level
     */
    function sendfile($filename)
    {
        $this->response->sendfile($filename);
    }


    /**
     * @param mixed $template_engine
     */
    public function setTemplateEngine($template_engine)
    {
        $this->template_engine = $template_engine;
    }

    /**
     * @return mixed
     */
    public function getTemplateEngine()
    {
        return $this->template_engine;
    }

    public function render(string $view_name, array $model): string
    {
        return $this->template_engine->render($view_name, $model);
    }

    public function renderPage(string $view_name, array $model)
    {
        return $this->end($this->template_engine->render($view_name, $model));


    }

}

?>