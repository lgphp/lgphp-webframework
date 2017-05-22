<?php
/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-14
 * Time: 上午1:30
 */

require_once "../lgphp/Lgphp.php";
require_once "./routermap/AdminRouters.php";
require_once "./controller/AdminController.php";



$app = new App((new Config())->setHost("127.0.0.1")->setPort(3002)->setStaticFileFolder("/public"));

SessionConfig::setSession(function (SessionConfig $config) {

    $config->setTimeout(30);

})->sessionStart();


$app->addHandler(new class(array(
    array("GET", "/test/*"),
    array("POST", "/post")
)) extends Handler
{
    function callback()
    {
        return function (Request $req, Response $res) {
            echo "路过中间件--中间件拦截\n";
            return $res->next();
        };
    }


});


$app->addHandler(new Csrf("x_csrf", "token", "禁止访问", array(

    array("POST", "/user/showuser"),


)));


RouteHandler::POST("/user/adduser", function (Request $req, Response $res) {
    var_dump($req->server("request_method"));
    var_dump($req->bodyParams("info"));
//    $a = $req->bodyParams("info");
//    var_dump($a);

});


//RouteHandler::GET("/page/:page", function (Request $req, Response $res) {
//
//    $page = $req->urlParams("page");
//    $res->send($page);
//});
//
//RouteHandler::GET("/user/:page/info/:id", function (Request $req, Response $res) {
//
//    $page = $req->urlParams("page");
//    $page .= $req->urlParams("id");
//    $res->send($page);
//});
//
//RouteHandler::GET("/page", function (Request $req, Response $res) {
//
//    $res->send("page");
//});
//
//RouteHandler::GET("/logout", function (Request $req, Response $res) {
//    $queryvar = $req->queryParmas("intro");
//    $res->send($queryvar);
//});


//RouteHandler::addRouterGroup("/api", array(
//
//    ChildRouter::newChildRouter("GET", "/test", function (Request $req, Response $res) {
//        $res->send("/api/test");
//    }),
//
//    ChildRouter::newChildRouter("GET", "/test2", function (Request $req, Response $res) {
//        $res->send("/api/test2");
//    }),
//
//));

//
//RouteHandler::GET("/set/:username", function (Request $req, Response $res) {
//    echo $req->queryParmas("test");
//    $a = $req->urlParams("username");
//    Session::setSession("username", $a);
//    Session::setSession("login", 1);
//    $res->send("hello world!");
//
////    $a = $req->bodyParams("info");
////    var_dump($a);
//
//});
//
//RouteHandler::GET("/d", function (Request $req, Response $res) {
//    Session::deleteSession("username");
//
//    $res->send("deleteSesssion");
////    $a = $req->bodyParams("info");
////    var_dump($a);
//
//});
//
//RouteHandler::GET("/g", function (Request $req, Response $res) {
//    $username = Session::getSession("username");
//    $sid = Session::getSessionID();
//    $login = Session::getSession("login");
//    $res->send("getsession::" . $username . "sessionid:" . $sid . "login:=" . $login);
////    $a = $req->bodyParams("info");
////    var_dump($a);
//
//});
//
//RouteHandler::GET("/de", function (Request $req, Response $res) {
//    Session::destorySession();
//    $res->send("destorySession");
////    $a = $req->bodyParams("info");
////    var_dump($a);
//
//});


RouteHandler::GET("/", function (Request $req, Response $res)  {
    $t = $res->getTemplateEngine()->render('index', ['name' => 'lgphp']);
    return $res->end($t);


});

RouteHandler::GET("/json", function (Request $req, Response $res): bool {
    $arr = array("key" => "helloword");
    $res->sendJson(json_encode($arr));
    return $res->die();
//    $a = $req->bodyParams("info");
//    var_dump($a);

});


RouteHandler::GET("/test", function (Request $req, Response $res): bool {

    $res->send("helloworld");
    return $res->end();
//    $a = $req->bodyParams("info");
//    var_dump($a);

});


RouteHandler::GET("/test/test2", function (Request $req, Response $res) {

    $res->send($req->server("request_uri"));
//    $a = $req->bodyParams("info");
//    var_dump($a);

});

RouteHandler::POST("/post", function (Request $req, Response $res) {

    echo "post";
//    $a = $req->bodyParams("info");
//    var_dump($a);

});


AdminRouters::runAdminRouters();

$app->startApp($app);

?>