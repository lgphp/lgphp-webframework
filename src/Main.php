<?php
/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-14
 * Time: 上午1:30
 */

require_once "../lgphp/Lgphp.php";
require_once "../vendor/autoload.php";
require_once "routermap/AdminRouters.php";
require_once "controller/AdminController.php";
require_once "../eureka/eurekaclient/Conf.php";
require_once "../eureka/eurekaclient/RegisterService.php";


$app = new App((new Config())->setHost("0.0.0.0")
    ->setPort(3008)->setStaticFileFolder("/statics")
    ->setGizp(true)->setPageCache(true)
    ->setWorkerNum(6)->setReactorNum(2));


$app->setTemplateDir("/src/views");


$app->add404Page(function (Request $req, Response $res) {

    $res->end("oop! page is not Found");

});


$app->add500Page(function (Request $req, Response $res) {

    $res->end("500 internal error!");

});
//SessionConfig::setSession(function (SessionConfig $config) {
//
//    $config->setTimeout(30);
//
//})->sessionStart();


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


//$app->addHandler(new Csrf("x_csrf", "token", "禁止访问", array(
//
//    array("POST", "/user/showuser"),
//
//
//)));


//RouteHandler::POST("/user/adduser", function (Request $req, Response $res) {
//    var_dump($req->server("request_method"));
//    var_dump($req->bodyParams("info"));
////    $a = $req->bodyParams("info");
////    var_dump($a);
//
//});


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


RouteHandler::addRouterGroup("/api", array(

    ChildRouter::newChildRouter("GET", "/test", function (Request $req, Response $res) {

        $ret = Requests::GET('http://www.baidu.com');
        var_dump($ret);
        $res->send("/api/test" . $ret->status_code);
    }),

    ChildRouter::newChildRouter("GET", "/test2", function (Request $req, Response $res) {
        $res->send("/api/test2");
    }),


    ChildRouter::newChildRouter("GET", "/jsonone", function (Request $req, Response $res) {
        $json = '{"product_name" : "奔驰汽车" , "price" : 100000.00 }';
        $res->sendJson($json);
        $res->end();
    }),

    ChildRouter::newChildRouter("GET", "/jsontwo", function (Request $req, Response $res) {
        $json = array('product_name' => '宝马汽车', 'price' => 12000);
        $res->sendJson(json_encode($json, JSON_UNESCAPED_UNICODE));
        $res->end();
    })

));

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

RouteHandler::GET("/info", function (Request $req, Response $res) {

//
//    Swoole\Async::dnsLookup("192.168.0.101", function ($domainName, $ip) use ($res) {
//        $cli = new swoole_http_client($ip, 2200);
//
//        $cli->setHeaders([
//            'Host' => $domainName,
//            "User-Agent" => 'Chrome/49.0.2587.3',
//            'Accept' => 'text/html,application/xhtml+xml,application/xml',
//            'Accept-Encoding' => 'gzip',
//        ]);
//        $cli->get('/demosuccess', function ($cli) use ($res) {
//            echo "Length: " . strlen($cli->body) . "\n";
//            $res->end($cli->body);
//        });
//    });


    $info = array('ServiceName' => 'CX_SERVICE_TRADE', 'ServiceIntro' => '交易核心服务', 'Author' => 'lugoang@52cx.com',
        'decription' => 'Base of Lgphp Framework1.0');
    //$view = $res->render('index', ['name' => phpinfo()]);
    // return $res->end($view);
    $res->sendJson(json_encode($info, JSON_UNESCAPED_UNICODE));
    $res->end();
});


RouteHandler::GET("/", function (Request $req, Response $res) {
    $arr = array("key" => "lgphp高性能php7框架");
    $res->sendJson(json_encode($arr, JSON_UNESCAPED_UNICODE));
    return $res->end();
});

RouteHandler::GET("/json", function (Request $req, Response $res): bool {
    $arr = array("key" => "this is benchmark");
    $res->sendJson(json_encode($arr));
    return $res->end();

});

RouteHandler::POST("/post", function (Request $req, Response $res) {

    echo "post";
    $a = $req->bodyParams("info");
    var_dump($a);

});

RouteHandler::GET("/json2", function (Request $req, Response $res) {

    $json = '{"price":200,"midle":150,"low":100}';//注意外面的单引号
    $res->sendJson($json);
    return $res->end();
});
//
//
//RouteHandler::GET("/test", function (Request $req, Response $res): bool {
//
//    $res->send("helloworld");
//    return $res->end();
////    $a = $req->bodyParams("info");
////    var_dump($a);
//
//});
//
//
//RouteHandler::GET("/test/test2", function (Request $req, Response $res) {
//
//    $res->send($req->server("request_uri"));
////    $a = $req->bodyParams("info");
////    var_dump($a);
//
//});
//

//
//
AdminRouters::runAdminRouters();


/*
 * 将服务注册到eureka上
 */


RegisterService::initConf();
if (RegisterService::regEurekaService()) {
    RegisterService::heartBeat();
}


//Conf::initConf("dev");
$app->startApp($app);

?>