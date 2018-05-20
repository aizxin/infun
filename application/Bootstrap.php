<?php
/**
 * @name Bootstrap
 * @author afoii-12\administrator
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf\Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */

use think\Db;

class Bootstrap extends Yaf\Bootstrap_Abstract {

    public function _initConfig() {
		//把配置保存起来
		$arrConfig = Yaf\Application::app()->getConfig();
		Yaf\Registry::set('config', $arrConfig);
	}

	public function _initPlugin(Yaf\Dispatcher $dispatcher) {
		//注册一个插件
		$objSamplePlugin = new SamplePlugin();
		$dispatcher->registerPlugin($objSamplePlugin);
	}

	public function _initRoute(Yaf\Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,默认使用简单路由
	}
	
	public function _initView(Yaf\Dispatcher $dispatcher) {
		//在这里注册自己的view控制器，例如smarty,firekylin
	}
	/**
	 * [_initAutoload 加载composer包]
	 * @param  Yaf\Dispatcher $dispatcher [description]
	 * @return [type]                     [description]
	 */
	public function _initAutoload(Yaf\Dispatcher $dispatcher)
	{
		// Yaf\Loader::import( APP_PATH . '/vendor/autoload.php' );
	}
	/**
	 * [_initThinkOrm top-think的 Orm]
	 * @param  Yaf\Dispatcher $dispatcher [description]
	 * @return [type]                     [description]
	 */
	public function _initThinkOrm(Yaf\Dispatcher $dispatcher)
	{
		// $config = Yaf\Application::app()->getConfig();
		// Db::setConfig([
		// 	// 数据库类型
		//     'type'            => "Mysql",
		//     // 服务器地址
		//     'hostname'        => $config->db->host,
		//     // 数据库名
		//     'database'        => $config->db->database,
		//     // 用户名
		//     'username'        => $config->db->username,
		//     // 密码
		//     'password'        => $config->db->password,
		//     // 端口
		//     'hostport'        => '3306',
		//     // 表前缀
		//     'prefix'          => 'ccwb_',
		// ]);
	}
}
