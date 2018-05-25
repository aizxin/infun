<?php
/**
 * @name IndexController
 * @author afoii-12\administrator
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class IndexController extends Yaf\Controller_Abstract {

	/** 
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/yaf_orm/index/index/index/name/afoii-12\administrator 的时候, 你就会发现不同
     */
	public function indexAction() {
		//1. fetch query
		// $get = $this->getRequest();
		// var_dump($get);
		// var_dump(Server::$get);
		// //2. fetch model
		// // $modelSample = new SampleModel();
		// // $modelUser = new UserModel();
		// var_dump(\think\Db::getConfig());
		// var_dump($modelSample->all()->toArray());
		// var_dump($modelUser->all()->toArray());
		//3. assign
		// $this->getView()->assign("content",'djjf');
		// $this->getView()->assign("name", $name);
		// var_dump('Hello World');
		//4. render by Yaf, 如果这里返回FALSE, Yaf将不会调用自动视图引擎Render模板
		// return false;
		// return 'Hello World' . PHP_EOL;
		// $client = new \swoole_client(SWOOLE_SOCK_TCP);
		// if (!$client->connect('127.0.0.1', 9503,-1))
		// {
		// 	exit("connect failed. Error: {$client->errCode}\n");
		// }
		// $client->send("select * from users");
		// var_dump($client->recv());
		// $client->close();
		$mysql = \Yaf\Registry::get('db')->pop();
        //var_dump($mysql);
        $get = $mysql->query("select * from `admin` where id=1 limit 1 ");
        echo json_encode($get);
		\Yaf\Registry::get('db')->push($mysql);
		$redis = \Yaf\Registry::get('redis')->pop();
        //var_dump($mysql);
        $get = $redis->set('ansjn','ndjand');
		echo json_encode($get);
		$get = $redis->get('ansjn');
		var_dump($get);
		\Yaf\Registry::get('redis')->push($redis);
		var_dump(\Yaf\Registry::get('config')['swoole']['worker_num']);
		echo \Yaf\Registry::get('log')->info('ansaadand').PHP_EOL;
		$this->getView()->assign("content", "Hello World");
	}
}
