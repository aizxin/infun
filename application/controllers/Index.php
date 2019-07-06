<?php
/** 
 * @Author: whero 
 * @Date: 2018-05-26 17:42:17 
 * @Desc: 默认控制器 
 */

use swf\facade\Log;

class IndexController extends Controller {

	/** 
	 * @Author: whero 
	 * @Date: 2018-05-26 17:45:05 
	 * @Desc: 默认动作 
	 */	
	public function indexAction() {
//        \swf\facade\Cache::set('123bdsqjbd',1234567);
//	    var_dump(\swf\facade\Cache::get('123bdsqjbd'));
//        \swf\facade\Db::run(['type'=>'mysql']);
//        $modelUser = new \App\Models\UserModel();

//         var_dump($modelUser);
//
//        var_dump($modelUser->cache());

//        $cache = \swf\facade\Cache::init();
//        var_dump($cache->handler());

//        $cache = \think\facade\Cache::init();
//        var_dump($cache);
////

//        $handler = \swf\facade\Cache::handler();
//        var_dump($handler->handler()->keys('*'));
//
//        var_dump($handler->get('123'));
//
//        var_dump($handler->get('123'));
//
//
//        var_dump($handler->handler()->get('1234'));
//
//        var_dump('1111');

//        Log::write('12334');

//        var_dump(\Yaconf::get('listener'));

//        foreach (\Yaconf::get('listener') as $listener) {
//            var_dump($listener);
//        }

//        $container = \think\Container::getInstance();

//        $listener = [
//            '\App\Listener\UserListener',
//        ];
//
//        var_dump($listener);

//        $container = \think\Container::getInstance();
//        $provider = $container->make(\swf\event\ListenerProvider::class);
//        $container->make(\swf\event\ListenerProviderFactory::class)->registerConfig($provider,$container,$listener);




//        var_dump(method_exists(\App\Listener\UserListener::class, 'process'));
//
//
//        var_dump($container->make(\swf\event\ListenerProvider::class)->listeners);

//        var_dump(\Swoole\Coroutine::run);
//
//        \think\Container::getInstance()
//            ->make(\swf\event\EventDispatcher::class)
//            ->dispatch(new \swf\process\event\ServerEvent(\Yaf\Registry::get('swoole')));

//        \swf\facade\Timer::tick(2000,function (){
//            var_dump(time());
//        });

//        \swf\task\Task::async(function (){
//            var_dump(1233);
//        });

//        var_dump(\Yaconf::get('redis'));

//        $redis = (\think\Container::getInstance()->make(\swf\redis\RedisFactory::class)->get('default'));

//        echo $redis->get('1111');

        \swf\queue\Queue::push(\App\Queue\TestQueue::class,['123'=>123467]);

        \swf\queue\Queue::later(10,\App\Queue\TestQueue::class,['12334'=>123467]);
        var_dump('1233');
	}
}
