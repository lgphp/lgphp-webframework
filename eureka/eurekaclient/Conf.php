<?php
/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17/2/20
 * Time: 18:09
 */
require_once (dirname(dirname(dirname(__FILE__)))."/vendor/mustangostang/spyc/Spyc.php");


define('eureka_defaultZone', getenv('EUREKA_IP') ?: '0.0.0.0/eureka');
define('server_ip', getenv('SERVER_IP') ?: getenv('HOSTNAME'));
define('server_port', getenv('SERVER_PORT') ?: '8080');
define('service_name', getenv('SERVICE_NAME') ?: 'noNameService');
define('hostname',getenv('HOSTNAME'));

class  Conf{


    private   $serv_info = array();


    public function __construct()
    {
        $this->serv_info = [

            'eureka_url' => eureka_defaultZone . '/apps',
            'server_ip' => server_ip,
            'server_port' => server_port,
            'service_name' => service_name,
            'host_name' => hostname

        ];
    }




    public   function  getEurekaUrl() :string {
        return $this->serv_info['eureka_url'];
    }

    public function  getServerIp(){
        return $this->serv_info['server_ip'];
    }
    public function  getServerPort(){
        return $this->serv_info['server_port'];
    }
    public function getServiceName(){
        return $this->serv_info['service_name'];
    }

    public function  getHostName(){
        return $this->serv_info['host_name'];
    }





    public static function initConf(string $profile=null){
        $addr = array(
            "given" => "Chris",
            "family"=> "Dumars",
            "address"=> array(
                "lines"=> "458 Walkman Dr.
        Suite #292",
                "city"=> "Royal Oak",
                "state"=> "MI",
                "postal"=> 48046,
            ),
        );
        $invoice = array (
            "invoice"=> 34843,
            "date"=> "2001-01-23",
            "bill-to"=> $addr,
            "ship-to"=> $addr,
            "product"=> array(
                array(
                    "sku"=> "BL394D",
                    "quantity"=> 4,
                    "description"=> "Basketball",
                    "price"=> 450,
                ),
                array(
                    "sku"=> "BL4438H",
                    "quantity"=> 1,
                    "description"=> "Super Hoop",
                    "price"=> 2392,
                ),
            ),
            "tax"=> 251.42,
            "total"=> 4443.52,
            "comments"=> "Late afternoon is best. Backup contact is Nancy Billsmer @ 338-4338.",
        );

// 把该 invoice 转换生成 YAML 的表示法
        $yaml = yaml_emit($invoice);

        $_profile = "application.yml";
        if($profile != null)  $_profile = "../resource/application_".$profile.".yaml";
        self::$serv_info = Spyc::YAMLLoad($_profile);

        var_dump(Conf::$serv_info);
    }

}


?>