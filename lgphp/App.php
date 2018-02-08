<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-14
 * Time: 上午1:08
 */


class App
{

    private static $handler_index = 0;
    private $server;
    private $Handlers = array();
    private $errorPageHander = array();
    private $serverConfig;
    private $ssl_key_dir;
    private $route_set = array();
    private $template_engine;
    private $template_dir = "/views";

    public function __construct(Config $config)
    {

        $this->serverConfig = $config instanceof Config ? $config : new Config();

        if ($this->serverConfig->isSsl()) {

            $this->newHttpsServer();
        } else {
            $this->newHttpServer();
        }

        $this->initHandlers();
    }



    private function newHttpServer()
    {
        $this->server = new swoole_http_server($this->serverConfig->getHost(), $this->serverConfig->getPort(), SWOOLE_BASE);

        $this->server->set(array(
            'worker_num' => $this->serverConfig->getWorkerNum(),
            'dispatch_mode' => $this->serverConfig->getDispatchMode(),   //固定分配请求到worker
            'reactor_num' => $this->serverConfig->getReactorNum(),     //亲核
             'daemonize' => true,       //守护进程
            //'backlog' => 128,
            //'log_file' => '/data/log/test_http_server.log',
        ));
    }




    private function newHttpsServer()
    {


        $this->ssl_key_dir = dirname(dirname(__DIR__)) . '/ssl';//sslkey文件存放目录
        $this->server = new swoole_http_server($this->serverConfig->getHost(), $this->serverConfig->getPort(),
            SWOOLE_BASE, SWOOLE_SOCK_TCP | SWOOLE_SSL);
        /**
         *     要使用https 需要在编译swoole的时候加上以下
         *     ./configure --enable-sockets --enable-openssl
         */


        $this->server->set(array(
            'worker_num' => $this->serverConfig->getWorkerNum(),
            'dispatch_mode' => $this->serverConfig->getDispatchMode(),   //固定分配请求到worker
            'reactor_num' => $this->serverConfig->getReactorNum(),     //亲核
            'open_http2_protocol' => 1,
            'ssl_cert_file' => $this->ssl_key_dir . '/' . $this->serverConfig->getSslCertFile(),
            'ssl_key_file' => $this->ssl_key_dir . '/' . $this->serverConfig->getSslKeyFile(),
            //'daemonize' => 1,       //守护进程
            //'backlog' => 128,
            //'log_file' => '/data/log/test_http_server.log',
        ));

    }



    private function initHandlers()
    {
        /**
         * 配置默认的错误处理handelers
         */
        $fn_page404page = function (Request $req, Response $res) {
            $res->status(404);
            $res->send("page not found");
        };
        $fn_page500page = function (Request $req, Response $res, Exception $error) {
            $res->status(500);
            $res->send("internal server error" . $error->getMessage());
        };
        $this->errorPageHander["404"] = $fn_page404page;
        $this->errorPageHander["500"] = $fn_page500page;
    }

    public function addHandler(Handler $handler)
    {
        $this->Handlers[self::$handler_index] = $handler;
        self::$handler_index++;

    }

    /*
     * 路由handler始终放在最后
     * 静态服务handler放在最前
     * 其次就是各种中间件
     * 再次是路由handler
     * 最后是error处理handler
     *
     */

    public function add404Page($fn)
    {
        $this->errorPageHander["404"] = $fn;
    }

    public function add500Page($fn)
    {
        $this->errorPageHander["500"] = $fn;
    }

    /**
     * @param string $template_dir
     */
    public function setTemplateDir(string $template_dir = "/src/views")
    {
        $this->template_dir = $template_dir;
    }

    /**
     * @param App $app
     */

    public function startApp(App $app)
    {

        $this->setupHandlers();

        foreach ($this->Handlers as $handler) {
            $handler->setRouters();
            foreach ($handler->getRouters() as $m) {
                // var_dump($m[0]."=>".$m[1]);
                array_push($this->route_set, array(strtoupper($m[0]), $m[1], $handler->callback()));
            }
        }
        //var_dump("=====================");
        foreach (RouteHandler::getRouterHandlers() as $m) {
            //var_dump($m[0]."=>".$m[1]);
            array_push($this->route_set, array(strtoupper($m[0]), $m[1], $m[2]));

        }

        /**
         * 启动模板引擎
         */
        $this->template_engine = new League\Plates\Engine(dirname(__DIR__) . $this->template_dir);
        $this->start();

    }

    private function setupHandlers()
    {

        $staticFileHandler = new StaticFilesHandler($this->serverConfig, array(
            ["GET", "/*"],
            ["HEAD", "/*"]
        ));
        array_unshift($this->Handlers, $staticFileHandler);
    }

    private function start()
    {

        $fn = function (swoole_http_request $req, swoole_http_response $res) {
            $request = new Request($req);
            $response = new Response($res);
            $response->setTemplateEngine($this->template_engine);
            try {
                if (Session::isSessionStarted()) {
                    Session::createSession(SessionConfig::getSessionConfig(), $req, $res);
                }

                $req_method = strtoupper($req->server["request_method"]);
                $req_path = $request->server("path_info") ?? $request->server("request_uri");
                //  echo $request->server("path_info")."====>".$request->server("request_uri");
                $handlers = Handlers::HandlersLoop($this->route_set, $req_path, $req_method);
                if (!empty($handlers)) {
                    $next = false;
                    foreach ($handlers as $handler) {
                        $fn = $handler[1];
                        $request->setUrlParams($handler[0]);
                        $next = $fn($request, $response);
                        if (!$next) break;
                    }
                    if ($next) $this->errorPageHander["404"]($request, $response);
                } else {
                    $this->errorPageHander["404"]($request, $response);
                }
            } catch (Exception $ex) {

                $this->errorPageHander["500"]($request, $response, $ex);
            }


        };

        $this->server->on("request", $fn);
        print ("server is running at port:{$this->serverConfig->getPort()}" . "\n");
        $this->server->start();
    }

}


?>