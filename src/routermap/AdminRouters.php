<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-21
 * Time: 下午11:46
 */


class AdminRouters
{
    public static function runAdminRouters()
    {
        RouteHandler::addRouterGroup("/admin",array(
            ChildRouter::newChildRouter("GET","/login", AdminController::login()),
            ChildRouter::newChildRouter("GET","/logout",AdminController::logout()),
        ));
    }
}