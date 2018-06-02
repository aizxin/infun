<?php

/** 
 * @Author: whero 
 * @Date: 2018-05-26 17:39:56 
 * @Desc:  
 */

class Bootstrap extends \Yaf\Bootstrap_Abstract {

    public function _initConfig() {
		//把配置保存起来
		$arrConfig = \Yaf\Application::app()->getConfig();
		\Yaf\Registry::set('config', $arrConfig);
	}

	public function _initPlugin(\Yaf\Dispatcher $dispatcher) {
		//注册一个插件
		$objSamplePlugin = new SamplePlugin();
		$dispatcher->registerPlugin($objSamplePlugin);
	}

	public function _initRoute(\Yaf\Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,默认使用简单路由
	}
	
	public function _initView(\Yaf\Dispatcher $dispatcher) {
		$dispatcher->disableView();
		//在这里注册自己的view控制器，例如smarty,firekylin
		\Yaf\Registry::set('html', new \think\Template([
            'view_path'	=>	APP_PATH .'/application/views/',
            'cache_path'	=>	APP_PATH .'/runtime/temp/',
            'view_suffix'   =>	'html',
        ]));
	}
	/** 
	 * @Author: whero 
	 * @Date: 2018-05-26 17:39:20 
	 * @Desc: 基于协程channel与协程mysql的数据库连接池 
	 */	
	public function _initDb(\Yaf\Dispatcher $dispatcher)
	{
		$mysqlDB = new CoMysqlPool();
        \Yaf\Registry::set('db', $mysqlDB);
	}
	/** 
	 * @Author: whero 
	 * @Date: 2018-05-26 17:38:56 
	 * @Desc: 基于协程channel与协程redis的数据库连接池 
	 */	
	public function _initRedis(\Yaf\Dispatcher $dispatcher)
	{
		$redis = new CoRedisPool();
        \Yaf\Registry::set('redis', $redis);
	}
	/** 
	 * @Author: whero 
	 * @Date: 2018-05-26 17:39:09 
	 * @Desc: swoole的异步日志 
	 */	
	public function _initLog(\Yaf\Dispatcher $dispatcher)
	{
		// $log = new CoFileLog();
		// \Yaf\Registry::set('log', $log);
		$log = new \think\Log();
		$log->init([
			'type'=>'file',
			'path'=> APP_PATH .'/runtime/log/',
		]);
		\Yaf\Registry::set('log', $log);
	}
}
