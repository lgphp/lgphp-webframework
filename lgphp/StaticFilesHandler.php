<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-20
 * Time: 下午10:54
 */
class StaticFilesHandler extends Handler
{


    private $static_FileFolder="/public";

    public function __construct(string $static_filefolder = "/public", array $method_and_path = array("GET" => "/*"))
    {
        $this->static_FileFolder = $static_filefolder;
        parent::__construct($method_and_path);
    }

    function callback()
    {

        return function (Request $req, Response $res) : bool {


            $req_path = $req->server("request_uri");
            $is_dir = false;
            if (Util::endWith($req_path, "/")) $is_dir = true;
            if (!$is_dir) {
                //拼出文件路径
                $file_path = dirname(__DIR__) . $this->static_FileFolder . $req_path;

                if (file_exists($file_path)) {
                    //获得文件扩展名,根据扩展名来确定httpheader
                    $path_info = pathinfo($file_path);
                    $file_extname = $path_info['extension'];
                    $content_type = array_key_exists($file_extname, mime_type) ? mime_type[$file_extname] : "application/octet-stream";
                    $res->setMimeType($content_type);
                    $last_modified_time = filemtime($file_path);
                    $etag = md5_file($file_path);
                    $res->header("Last-Modified", gmdate("D, d M Y H:i:s", $last_modified_time) . " GMT");
                    $res->header("Etag", $etag);
                    if (strtotime($req->header("if-modified-since")) == $last_modified_time or trim($req->header("if-none-match")) == $etag) {
                        $res->status(304);
                        return  $res->end();
                    } else {
                        $res->sendfile($file_path);
                        return $res->die();
                    }

                } else {

                    return $res->next();
                }

            }
            return $res->next();

        };

    }


}