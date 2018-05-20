<?php

class Server
{
    public static $instance;
    public static $http;
    public static $get;
    public static $post;
    public static $header;
    public static $server;
    public static $cookies;
    public static $rawContent;
    public static $files;
    private $application;
    private $environment = 'product'; //product OR develop
    private function __construct()
    {
        define ('IS_SWOOLE', TRUE);
        define('APP_PATH', dirname(__DIR__));
        
        $config = new \Yaf\Config\Ini(APP_PATH . "/conf/application.ini",$this->environment);
        $config = ($config->toArray())['swoole'];
        $http = new \swoole_http_server($config['host'],$config['port']);
        unset($config['host']);
        unset($config['port']);
        $http->set($config);
        $http->on('WorkerStart', array($this, 'onWorkerStart'));
        $http->on('task', array($this, 'onTask'));
        $http->on('finish', array($this, 'onFinish'));
        $http->on('request', function ($request, $response) use($http) {
            //请求过滤,会请求2次
            if(in_array('/favicon.ico', [$request->server['path_info'],$request->server['request_uri']])){
                return $response->end();
            }

            Server::$server     = isset($request->server) ? $request->server :  [];
            Server::$header     = isset($request->header)   ? $request->header  : [];
            Server::$get        = isset($request->get)      ? $request->get     : [];
            Server::$post       = isset($request->post)     ? $request->post    : [];
            Server::$cookies    = isset($request->cookies)  ? $request->cookies : [];
            Server::$rawContent = $request->rawContent();
            Server::$http       = $http;
            Server::$files      = isset($request->files)  ? $request->files : [];

            ob_start();
            try {
                $yaf_request = new \Yaf\Request\Http($request->server['request_uri']);
                $this->application->getDispatcher()->dispatch($yaf_request);
                $result = ob_get_contents();
            } catch (\Exception $e ) {
                $result = $e->getMessage();
            }
            ob_end_clean();
            // add Header
            $response->header('Content-Type', 'application/json; charset=utf-8');
            // add cookies
            // set status
            $response->end($result);
        });
        $http->start();
    }
    public function onWorkerStart($serv, $worker_id)
    {
        $errorMsg = array();
        if(!defined('APP_PATH')){
            $errorMsg[] = 'APPLICATION_PATH未定义';
        }
        if(!is_dir(APP_PATH.'/application')){
            $errorMsg[] = 'application 文件夹不存在';
        }
        if(!empty($errorMsg)){
            var_dump($errorMsg);
            exit();
        }
        //错误信息将写入swoole日志中
        error_reporting(-1);
        ini_set('display_errors', 1);
        
        $this->application = new \Yaf\Application(APP_PATH . "/conf/application.ini",$this->environment);
        ob_start();
		$this->application->bootstrap();
		ob_end_clean();
    }
    public function onTask($serv, $taskId, $fromId, array $taskdata)
    {
        echo "新的异步任务[来自进程 {$fromId}，当前进程 {$taskId}],data:".json_encode($taskdata).PHP_EOL;
        //$task = TaskLibrary::createTask($taskdata);
    }
    public function onFinish($serv, $taskId, $data)
    {
        # code...
    }
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
Server::getInstance();
?>