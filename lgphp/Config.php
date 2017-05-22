<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-21
 * Time: 上午10:05
 */
class Config
{
    private $host = "0.0.0.0";
    private $port = "3000";
    private $static_file_folder = "/public";
    private $ssl = false;
    private $worker_num = 1;
    private $dispatch_mode = 4;
    private $reactor_num = 4;
    private $ssl_cert_file="ssl.crt";
    private $ssl_key_file = "ssl.key";

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * @param string $port
     */
    public function setPort(string $port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     */
    public function getStaticFileFolder(): string
    {
        return $this->static_file_folder;
    }

    /**
     * @param string $static_file_folder
     */
    public function setStaticFileFolder(string $static_file_folder)
    {
        $this->static_file_folder = $static_file_folder;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSsl(): bool
    {
        return $this->ssl;
    }

    /**
     * @param bool $ssl
     */
    public function setSsl(bool $ssl)
    {
        $this->ssl = $ssl;
        return $this;
    }

    /**
     * @return int
     */
    public function getWorkerNum(): int
    {
        return $this->worker_num;
    }

    /**
     * @param int $worker_num
     */
    public function setWorkerNum(int $worker_num)
    {
        $this->worker_num = $worker_num;
        return $this;
    }

    /**
     * @return int
     */
    public function getDispatchMode(): int
    {
        return $this->dispatch_mode;
    }

    /**
     * @param int $dispatch_mode
     */
    public function setDispatchMode(int $dispatch_mode)
    {
        $this->dispatch_mode = $dispatch_mode;
        return $this;
    }

    /**
     * @return int
     */
    public function getReactorNum(): int
    {
        return $this->reactor_num;
    }

    /**
     * @param int $reactor_num
     */
    public function setReactorNum(int $reactor_num)
    {
        $this->reactor_num = $reactor_num;
        return $this;
    }

    /**
     * @return string
     */
    public function getSslCertFile(): string
    {
        return $this->ssl_cert_file;
    }

    /**
     * @param string $ssl_cert_file
     */
    public function setSslCertFile(string $ssl_cert_file)
    {
        $this->ssl_cert_file = $ssl_cert_file;
    }

    /**
     * @return string
     */
    public function getSslKeyFile(): string
    {
        return $this->ssl_key_file;
    }

    /**
     * @param string $ssl_key_file
     */
    public function setSslKeyFile(string $ssl_key_file)
    {
        $this->ssl_key_file = $ssl_key_file;
    }





}