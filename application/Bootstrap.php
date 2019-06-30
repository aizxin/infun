<?php

/** 
 * @Author: whero 
 * @Date: 2018-05-26 17:39:56 
 * @Desc:  
 */

class Bootstrap extends \Yaf\Bootstrap_Abstract {

	public function _initPlugin(\Yaf\Dispatcher $dispatcher) {
		//注册一个插件
		$objSamplePlugin = new SamplePlugin();
		$dispatcher->registerPlugin($objSamplePlugin);
	}

    public function _initLoader(\Yaf\Dispatcher $dispatcher) {
        \Yaf\Loader::import( APP_PATH . '/vendor/autoload.php');
    }

	public function _initRoute(\Yaf\Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,默认使用简单路由
	}
	
	public function _initView(\Yaf\Dispatcher $dispatcher) {
        $dispatcher->disableView();
	}
	/** 
	 * @Author: whero 
	 * @Date: 2018-05-26 17:39:09 
	 * @Desc: swoole的异步日志 
	 */	
	public function _initLog(\Yaf\Dispatcher $dispatcher)
	{
//        \swf\facade\Log::init([
//            'type'=>'file',
//            'path'=> APP_PATH . '/runtime/logs/',
//        ]);
	}
}
