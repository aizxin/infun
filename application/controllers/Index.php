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
//	    var_dump(\swf\facade\Cache::get('123'));
//        var_dump(\swf\facade\Db::table('user')->select());
//        $modelUser = new \App\Models\UserModel();

//         var_dump($modelUser);
//
//        var_dump($modelUser->select()->toArray());

//        $cache = \swf\facade\Cache::init();
//        var_dump($cache->handler());

//        $cache = \think\facade\Cache::init();
//        var_dump($cache);
////
        $handler = \swf\facade\Cache::handler();

        	    var_dump(\swf\facade\Cache::get('123bdsqjbd'));


//        \swf\facade\Cache::get('')
////
//        $handler->set('123',123434);
        var_dump($handler->get('123'));
	}
}
