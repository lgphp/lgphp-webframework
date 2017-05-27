Lgphp - Lightning Fast, Effective, Simple web framework for PHP7
======================================================================
Lgphp is a micro webframework for building web application or high performance API service,  Lgphp was originally  
inspired by Kemal and Spark.
 
Lgphp intention to provide simple,high performace framework for developers that want to (or are required to),
 develop their web application or mobile API in PHP7. Lgphp provide elegant Routes, StaticFileService, Session,
 Csrf, Middleware, Database,https, WebSocket,template-render etc.., it is base on Swoole extension and use its network library.
 
beside, Lgphp is very Lighting, total size less than 1M, Lgphp can make you application fast as C. 


## Features
- Support all REST verbs
- Request/Response context, easy parameter handling
- Middlewares
- Built-in CSRF support
- Built-in Session support
- Built-in static file serving
- Built-in view templating via [plates](https://github.com/thephpleague/plates)
- https support

## come soon

- Built-in async Database support(Mysql)
- Built-in redis support
- Websocket support


## Getting started

require: PHP  >=7.0 
         swoole >=2.0.0

install PHP7.0 before install lgphp framework

Lgphp base on swoole 2.0.7[swoole](https://github.com/swoole/swoole-src/releases/tag/v2.0.7) 
download swoole sourcecode

- install swoole extension 
unzip swoole source,then make it
```
tar -xvzf swoole.tar.gz
cd swoole
phpize
./configure --enable-async-mysql --enable-async-httpclient --enable-sockets --enable-async-redis --enable-openssl
make
sudo make install
```
or  install by PECL
```
pecl install swoole

```
edit php.ini add follow line

```php
extension=swoole.so
```

run ```php -m``` or ```phpinfo()``` make sure swoole was loaded, otherwise run ```
php -i |grep php.ini```  show php.ini absolute path

- install Lgphp framework

download lgphp-framework's zip [lgphp](https://github.com/lgphp/lgphp-webframework/releases/tag/0.0.1)



## Examples

```php

require_once "../lgphp/Lgphp.php";

$app = new App();

RouteHandler::GET("/", function (Request $req, Response $res)  {
    return $res->end("Hello Lgphp");
});


$app->startApp($app);

```

Start your application!

```

php app.php

```

Go to http://localhost:3000

## Guide
- REST  verb

RouteHandler::GET
RouteHandler::POST
RouteHandler::DELETE
RouteHandler::PUT

- Route parameter
```php

RouteHandler::GET("/user/:page/info/:id", function (Request $req, Response $res) {

    $page = $req->urlParams("page");
    $page .= $req->urlParams("id");
    $res->send($page);
});


RouteHandler::POST("/post", function (Request $req, Response $res) {
 $bodyVal = $req->bodyParams("info");
});





```

- Route group
```php

RouteHandler::addRouterGroup("/api", array(

    ChildRouter::newChildRouter("GET", "/test", function (Request $req, Response $res) {
        $res->send("/api/test");
    }),

    ChildRouter::newChildRouter("GET", "/test2", function (Request $req, Response $res) {
        $res->send("/api/test2");
    }),

));

```

- Session

```php
SessionConfig::setSession(function (SessionConfig $config) {

    $config->setTimeout(30);

})->sessionStart();

//set Seesion
Session::setSession("login", 1);

//get Session
$login = Session::getSession("login");

//delete Session
Session::deleteSession("login");

// destory Session 

Session::destorySession();

// get SessionId

Session::getSessionID();

```
- CSRF

need Session started

```php

$app->addHandler(new Csrf("x_csrf", "token", "forbidden here!", array(
    //allowed route array
    array("POST", "/user/showuser"),  


)));

```

- Middleware 

```php

$app->addHandler(new class(array(
    //need Auth routes array
    array("GET", "/test/*"),  // "*" mean is all /test/ routes
    array("POST", "/post")
)) extends Handler
{
    function callback()
    {
        return function (Request $req, Response $res) {
            echo "here you can auth login";
            return $res->next();
        };
    }


});

```


- Static File Service
    - set host
    - set port
    - set StaticFileFolder
    - set Gzip
    - set Cache

```php
$app = new App((new Config())->setHost("127.0.0.1")
    ->setPort(3002)->setStaticFileFolder("/public")
    ->setGizp(true)->setPageCache(false)
    ->setWorkerNum(6)->setReactorNum(2));

```

-- render view

```php

RouteHandler::GET("/hello", function (Request $req , Response $res){
    $model = array("name"=>"lgphp");
    $view = $res->render('index', $model);
    return $res->end($view); 
});


```

```html

<h1>Lgphp-PHP</h1>
<p>Hello, <?=$this->e($name)?></p>

```
-- Service Json

```php
RouteHandler::GET("/", function (Request $req, Response $res)  {
    $arr = array("key" => "helloword");
    $res->sendJson(json_encode($arr));
    return $res->end();
});
```


-- Upload Files
```php




```



## Benchmark


Environment:
```
pc:lenovo ideapad s410
os: Linux mint 18.0
mem: 4G DDR
cpu: Intel(R) Core(TM) i3-4030U CPU @ 1.90GHz  2Core

```

```
lgphp@lgphp-mint ~ $ wrk -t3 -c1000 -d10s http://localhost:3002/
Running 10s test @ http://localhost:3002/
  3 threads and 1000 connections
  Thread Stats   Avg      Stdev     Max   +/- Stdev
    Latency    25.35ms   13.44ms 317.56ms   96.06%
    Req/Sec    12.07k     3.31k   19.23k    77.00%
  360292 requests in 10.06s, 56.35MB read
Requests/sec:    35802.13
Transfer/sec:      5.60MB

```