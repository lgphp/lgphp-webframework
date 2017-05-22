<?php
/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-17
 * Time: 下午8:51
 */





class Session
{

    private static $req;
    private static $res;
    private static $serverStoreSession;
    private static $sessionid;
    private static $session_Config;
    private static $session_started = false;
    private static $session_arr = array();

    public static function sessionStart()
    {

        self::$session_started = true;
    }

    public static function isSessionStarted()
    {

        return self::$session_started;
    }


    public static function createSession(SessionConfig $config, $req, $res)
    {


        self::$req = $req;
        self::$res = $res;
        self::$session_Config = $config;
        if (is_null(self::$serverStoreSession)) {
            self::$sessionid = Tools::getSessionID();
            self::$serverStoreSession = array(self::$sessionid => "");
        }
        self::$res->cookie(
            $config->getCookiename(),
            self::$sessionid,
            time() + $config->getTimeout(),
            $config->getPath(),
            $config->getDomain(),
            false,
            true);
    }


    public static function setSession(string $key, $val)
    {

        if (!empty(self::$sessionid) && !empty($key)) {
            self::$serverStoreSession[self::$sessionid][$key] = $val;
        }

    }

    public static function getSession(string $key)

    {
        if (isset(self::$session_Config)) {
            if (isset(self::$req->cookie[self::$session_Config->getCookiename()])) {
                if (is_array(self::$serverStoreSession[self::$sessionid])) {
                    if (array_key_exists($key, self::$serverStoreSession[self::$sessionid])) {
                        return self::$serverStoreSession[self::$sessionid][$key];
                    } else {
                        return null;
                    }
                }
            }
        }
        self::$serverStoreSession = null;
        return null;
    }

    public static function deleteSession(string $key)
    {

        unset(self::$serverStoreSession[self::$sessionid][$key]);

    }

    /*
     * 销毁所有session
     */

    public static function destorySession()
    {
        self::$res->cookie(
            self::$session_Config->getCookiename(),
            time() - 1
        );
        self::$serverStoreSession = null;
    }

    public static function getSessionID()
    {
        return self::$sessionid;
    }





}

?>