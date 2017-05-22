<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-20
 * Time: 下午9:24
 */
class Handlers
{

    //private static $handlers = array();

    public static function HandlersLoop(array $router_group, string $reqpath, string $methond = "GET")
    {

        $handlers = array();
        $router_len = count($router_group);
        $urlParser = new UrlParser();
        if ($router_len > 0) {
            foreach ($router_group as $router_arr) {
                if ($methond == $router_arr[0]) {
                    if ($urlParser->Match_RouterSplah($router_arr[1],$reqpath)){
                        $fn = $router_arr[2];
                        array_push($handlers, array(array(), $fn));
                    }
                    else if ($urlParser->Match_RouterUrlForParams($router_arr[1], $reqpath)) {
                        $urlparams = $urlParser->get_urlParams();
                        $fn = $router_arr[2];
                        array_push($handlers, array($urlparams, $fn));
                    }
                }
            }

        }

        return $handlers;
    }
}
