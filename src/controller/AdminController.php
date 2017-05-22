<?php

/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17-5-21
 * Time: 下午11:54
 */


class AdminController
{

     public static function login(){
         return function (Request $req,Response $res){
             $model = $res->render('login',array(
                'info'=>'登录页面-新方法'
             ));// $res->getTemplateEngine()->render('login', ['info' => '登录页面']);
             return $res->end($model);
         };
     }


    public static function logout(){
        return function (Request $req,Response $res){

            return  $res->renderPage('logout',array(
                'info'=>'退出登录-新方法'
            ));
        };
    }
}