Lgphp - Lightning Fast, Effective, Simple web framework for PHP7
======================================================================
Lgphp is a micro webframework for building web application or high performance API service,  Lgphp was originally  
inspired by Kemal and Spark.
 
Lgphp intention to provide simple,high performace framework for developers that want to (or are required to),
 develop their web application or mobile API in PHP7. Lgphp provide elegant Routes, StaticFileService, Session,
 Csrf, Middleware, Database,https, WebSocket,template-render etc.., it is base on Swoole extension and use its network library.
 
beside, Lgphp is very Lighting, total size less than 1M, Lgphp can make you application fast as C. 


## Features

## Getting started

## Examples

```
require_once "../lgphp/Lgphp.php";

$app = new App();

RouteHandler::GET("/", function (Request $req, Response $res)  {
    return $res->end("Hello Lgphp");
});


$app->startApp($app);

```php

Start your application!

```

php app.php

```

Go to http://localhost:3000