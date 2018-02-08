<?php
/**
 * Created by PhpStorm.
 * User: lgphp
 * Date: 17/2/20
 * Time: 17:56
 */



class  RegisterService
{

    private static $server_ip;
    private static $server_port;
    private static $eureka_baseUrl;
    private static $service_name;
    private static $instance_id;

    /*
     * 初始化配置
     */

    public static function initConf()
    {
        $srv_info = new Conf();
        self::$server_ip = $srv_info->getServerIp();
        self::$server_port =$srv_info->getServerPort();
        self::$eureka_baseUrl = $srv_info->getEurekaUrl();
        self::$service_name = $srv_info->getServiceName();
        self::$instance_id = $srv_info->getHostName() . ':' . $srv_info->getServerPort() . ':' .$srv_info->getServiceName();

    }

    public static function regEurekaService()
    {
        //Requests::register_autoloader();
        try{
            $res = Requests::post(self::$eureka_baseUrl . '/' . self::$service_name ,
                array('Content-Type' =>'application/json') ,
                json_encode(self::warpInstanceData() , JSON_UNESCAPED_UNICODE));
            if ($res->status_code == 204) {
                self::logger(self::$service_name . '注册成功');

                //发送服务心跳
                return true;
            }
        }
        catch (Exception $err){
            self::logger(self::$service_name . '注册失败,程序退出' . $err->getMessage());
            exit(0);
        }

            return false;
    }


    public  static  function  heartBeat(){

        $heart_beat_secs = 5; //每5秒发送一次心跳
        $process = new \swoole_process(function (\swoole_process $process) use($heart_beat_secs){
            while (1){


            $res = Requests::put(self::$eureka_baseUrl . '/' . strtoupper(self::$service_name). '/'. self::$instance_id
                , array('Content_Type' => 'application/json') , array());

            self::logger('心跳发送成功' . self::$service_name);

            if ($res->status_code!==200 || $res->status_code!==204){
                self::logger('心跳发送失败' . self::$service_name);
                //$process->_exit(0);
            }
               sleep($heart_beat_secs);
            }
        });

        $process->start();
    }

    private static function warpInstanceData(): array
    {

        $now_ms_time = RegisterService::getMillisecond();
        $data = [
            'instance' => [
                'instanceId' => self::$instance_id,
                'hostName' => self::$server_ip,
                'app' => self::$service_name,
                'ipAddr' => self::$server_ip,
                'status' => 'UP',
                'overriddenstatus' => 'UNKNOWN',
                'port' => [
                    '$' => self::$server_port,
                    '@enabled' => 'true',
                ],
                'securePort' => [
                    '$' => 443,
                    '@enabled' => 'false',
                ],
                'countryId' => 1,
                'dataCenterInfo' => [
                    '@class' => 'com.netflix.appinfo.InstanceInfo$DefaultDataCenterInfo',
                    'name' => 'MyOwn',
                ],
                'leaseInfo' => [
                    'renewalIntervalInSecs' => 30,
                    'durationInSecs' => 10,
                    'registrationTimestamp' => $now_ms_time,
                    'lastRenewalTimestamp' => $now_ms_time,
                    'evictionTimestamp' => 0,
                    'serviceUpTimestamp' => $now_ms_time,
                ],
                'metadata' => [
                    '@class' => 'java.util.Collections$EmptyMap',
                ],
                'homePageUrl' => 'http://' . self::$server_ip . ':' . self::$server_port . '/',
                'statusPageUrl' => 'http://' . self::$server_ip . ':' . self::$server_port . '/info',
                'healthCheckUrl' => 'http://' . self::$server_ip . ':' . self::$server_port . '/health',
                'vipAddress' => strtolower(self::$service_name),
                'secureVipAddress' => strtolower(self::$service_name),
                'isCoordinatingDiscoveryServer' => 'false',
                'lastUpdatedTimestamp' => $now_ms_time,
                'lastDirtyTimestamp' => $now_ms_time,
                'actionType' => 'ADDED',
            ]
        ];

        return $data;
    }

    /**
     * 获取毫秒数
     * @return float
     */

    private static function getMillisecond()
    {
        list($s1, $s2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }

    private static function  logger($msg=''){

        $str_date = date("Y-m-d H:i:s");
        $log_message  = $str_date.' : ' .$msg . "\n";
       // print($log_message . "\n");
        error_log($log_message,3,__DIR__.'eureka.logs');
    }


}