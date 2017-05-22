<?php
/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-17
 * Time: 下午8:58
 */




class SessionConfig
{
    /*
     * $key, $value, $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = false
     */
    private $cookiename;
//    private $value;
    private $timeout;
    private $domain;
    private $secure;
    private $path;
    private static $ConfigInstance;

    public function __construct()
    {
        $this->cookiename = "lgphp_sessionid";
        $this->timeout = time() + 1200; // 默认20分钟
        $this->domain = "";
        $this->path = "/";
        $this->secure = false;

    }


    public static function getSessionConfig()
    {

        return self::$ConfigInstance;
    }

    /**
     * @param $fn
     * 返回一个config配置实例
     */
    public static function setSession($fn)
    {

        self::$ConfigInstance = new SessionConfig();
        $fn(self::$ConfigInstance);
        return new Session();

    }

    /**
     * @param int $timeout
     */
    public function setTimeout(int $seconds)
    {
        $this->timeout = $seconds;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain)
    {
        $this->domain = $domain;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }


    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getCookiename(): string
    {
        return $this->cookiename;
    }

}