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

before install lgphp, install PHP7.0 please.

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

## benchmark


Environment:
```
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