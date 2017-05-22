<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-15
 * Time: 下午2:35
 */
class UrlParser
{


    /*
     * 判断pathinfo中是否有:var的参数
     * return :boolean
     */
    private $url_params = array();

    public function match_var($v)
    {
        return preg_match('/^(:)[a-zA-Z]+$/i', $v);
    }


    /*
     * 匹配中间件有*号的的模式
     * =>/api/* = >（ /api/a  /api/b, /api/ , /api）
     */
    public function Match_RouterSplah($router_url, $req_pathinfo)
    {
        $partten = "/";
        if (Util::endWith($router_url, "*")) {
            $partten = substr($router_url, 0, -1);
            if (Util::startWith($req_pathinfo, $partten) || Util::startWith($req_pathinfo, substr($partten, 0, -1))) {
                return true;
            }
        } else {
            return false;
        }
        return false;
    }


    public function Match_RouterUrlForParams($router_url, $req_pathinfo)
    {
        if (Util::endWith($router_url, "*")) return false;
        if ($router_url == $req_pathinfo) return true;
        $url_path = substr($router_url, 1);
        $urlinfo = explode("/", $url_path);
        $path_regstr = "/^";
        $i = 1;
        foreach ($urlinfo as $e) {
            $path_regstr .= "(\/";
            $path_regstr .= ")";
            if ($this->match_var($e)) {
                $path_regstr .= "[a-zA-Z0-9\x{4e00}-\x{9fff}]*";
                $this->url_params[$e] = $i; //url 解析的参数
            } else {
                $path_regstr .= "(";
                $path_regstr .= $e;
                $path_regstr .= ")";
            }
            $i++;
        }
        if (Util::endWith($req_pathinfo, "/")) {
            $path_regstr .= "[\/]+$/ui";
        } else {
            $path_regstr .= "+$/ui";
        }

        return preg_match($path_regstr, $req_pathinfo, $m);


    }

    public function get_urlParams(): array
    {

        return $this->url_params;

    }

}

?>