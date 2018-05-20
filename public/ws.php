<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/3/27
 * Time: 上午12:50
 */
class Ws {

    public $ws = null;
    public static $instance;
    private $environment = 'product'; //product OR develop
    public static $request;
    private $application;
    public function __construct() {
        define ('IS_SWOOLE', TRUE);
        define('APP_PATH', dirname(__DIR__));
        
        $config = (new \Yaf\Config\Ini(APP_PATH . "/conf/application.ini",$this->environment))->toArray();
        $this->ws = new \swoole_websocket_server($config['sw']['host'],$config['sw']['port']);
        $this->ws->listen($config['sw']['host'], $config['sw']['chart_port'], SWOOLE_SOCK_TCP);
        $this->ws->set($config['swoole']);
        $this->ws->on("start", [$this, 'onStart']);
        $this->ws->on("open", [$this, 'onOpen']);
        $this->ws->on("message", [$this, 'onMessage']);
        $this->ws->on("workerstart", [$this, 'onWorkerStart']);
        $this->ws->on("request", [$this, 'onRequest']);
        $this->ws->on("task", [$this, 'onTask']);
        $this->ws->on("finish", [$this, 'onFinish']);
        $this->ws->on("close", [$this, 'onClose']);
        $server = $this->ws->addListener($config['sw']['host'], $config['sw']['client_port'], SWOOLE_SOCK_TCP);
        $server->set(array());
        $server->on("receive", function ($serv, $fd, $threadId, $data) {
            var_dump($fd);
            $serv->send($fd, "Swoole: {$data}");
            $serv->close($fd);
        });
        $this->ws->start();
    }

    /**
     * @param $server
     */
    public function onStart($server) {
        swoole_set_process_name("live_master");
    }
    /**
     * @param $server
     * @param $worker_id
     */
    public function onWorkerStart($server,  $worker_id) {
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

    /**
     * request回调
     * @param $request
     * @param $response
     */
    public function onRequest($request, $response) {
        //请求过滤,会请求2次
        if(in_array('/favicon.ico', [$request->server['path_info'],$request->server['request_uri']])){
            return $response->end();
        }

        Ws::$request = $request;

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

    }
    /**
     * @param $serv
     * @param $taskId
     * @param $workerId
     * @param $data
     */
    public function onTask($serv, $taskId, $workerId, $data) {
    }

    /**
     * @param $serv
     * @param $taskId
     * @param $data
     */
    public function onFinish($serv, $taskId, $data) {
        echo "taskId:{$taskId}\n";
        echo "finish-data-sucess:{$data}\n";
    }

    /**
     * 监听ws连接事件
     * @param $ws
     * @param $request
     */
    public function onOpen($ws, $request) {
    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame) {
    }

    /**
     * close
     * @param $ws
     * @param $fd
     */
    public function onClose($ws, $fd) {
    }

    /**
     * 记录日志
     */
    public function writeLog() {

    }
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
Ws::getInstance();