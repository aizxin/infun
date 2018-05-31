<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/3/27
 * Time: 上午12:50
 */
class HttpSever {
    public static $instance;
    private $env = 'product'; //product OR develop
    private $application;
    public function __construct() {
        define ('IS_SWOOLE', true);
        define('APP_PATH', dirname(__DIR__));
        
        $config = (new \Yaf\Config\Ini(APP_PATH . "/conf/application.ini",$this->env))->toArray();
        $ws = new \swoole_websocket_server($config['sw']['host'],$config['sw']['port']);
        $ws->set($config['swoole']);
        $ws->on("start", [$this, 'onStart']);
        $ws->on("open", [$this, 'onOpen']);
        $ws->on("message", [$this, 'onMessage']);
        $ws->on("workerstart", [$this, 'onWorkerStart']);
        $ws->on("request", [$this, 'onRequest']);
        $ws->on("task", [$this, 'onTask']);
        $ws->on("finish", [$this, 'onFinish']);
        $ws->on("close", [$this, 'onClose']);
        $ws->start();
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
            $errorMsg[] = 'APP_PATH未定义';
        }
        if(!is_dir(APP_PATH.'/application')){
            $errorMsg[] = 'application 文件夹不存在';
        }
        if(!empty($errorMsg)){
            var_dump($errorMsg);
            exit();
        }
        \Yaf\Registry::set('http', $server);
        \Yaf\Registry::set('env', $this->env);
        //错误信息将写入swoole日志中
        error_reporting(-1);
        ini_set('display_errors', 1);
        
        $this->application = new \Yaf\Application(APP_PATH . "/conf/application.ini",$this->env);
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

        \Yaf\Registry::set('request', $request);
        \Yaf\Registry::set('response', $response);

        ob_start();
        try {
            $yaf_request = new \Yaf\Request\Http($request->server['request_uri'],'/');
            $this->application->getDispatcher()->throwException(true)->dispatch($yaf_request);
        } catch (\Yaf\Exception $e ) {
            // Yaf\View\Simple::render("error.phtml");
            // var_dump($e);
            // $result = $e->getMessage();
            $response->status(302);
            $response->header("Location", "http://127.0.0.1:9501/index/error/error");
        }
        $result = ob_get_contents();
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
        echo "AsyncTask[$task_id] Finish: $from_id".PHP_EOL;
        // $serv->send($data, "Swoole: 你好");
        var_dump($data);
        return $data;
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
        echo '===============' . date("Y-m-d H:i:s", time()) . '欢迎' . $request->fd . '进入==============' . PHP_EOL;
    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame) {
        $data = json_decode($frame->data, true);
        $result = [];
        $result['fd'] = $frame->fd;
        $result['data'] = $frame->data;
        $requestObj = new \Yaf\Request\Http($data['uri'], '/');
        $requestObj->setParam($result);
        ob_start();
        try {
            $this->yafObj->getDispatcher()->dispatch($requestObj);
        } catch (Yaf\Exception $e) {
            var_dump($e);
        }
        ob_end_clean();
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
HttpSever::getInstance();