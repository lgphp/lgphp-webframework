<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-14
 * Time: 上午2:15
 */
class RouteHandler
{

    /**
     * [["GET","path","fn"],[]]
     */
    private static $routerHandlers = array();
    private static $routerGroups;

    public static function addRouterGroup(string $path, array $routerChildRouter)
    {
        foreach ($routerChildRouter as $childRouter) {
            $method_verb = $childRouter->getMethod();
            $single_router_path = Util::endWith($path, "/") ? substr($path, 0, -1) . $childRouter->getPath() : $path . $childRouter->getPath();
            switch ($method_verb) {
                case "GET":
                    self::GET($single_router_path, $childRouter->getFn());
                    break;
                case "POST":
                    self::POST($single_router_path, $childRouter->getFn());
                    break;
                case "DELETE":
                    self::DELETE($single_router_path, $childRouter->getFn());
                    break;
                case "PUT":
                    self::PUT($single_router_path, $childRouter->getFn());
                    break;
            }
        }


    }

    public static function GET(string $path, $fn)
    {


        array_push(self::$routerHandlers,array("GET",$path,$fn));

      //  self::$routerHandlers["GET"][$path] = $fn;

    }

    public static function POST(string $path, $fn)
    {
        array_push(self::$routerHandlers,array("POST",$path,$fn));
    }

    public static function DELETE(string $path, $fn)
    {
        array_push(self::$routerHandlers,array("DELETE",$path,$fn));
    }

    public static function PUT(string $path, $fn)
    {
        array_push(self::$routerHandlers,array("PUT",$path,$fn));
    }


    public static function getRouterHandlers() : array
    {
        return self::$routerHandlers;
    }




}


?>