<?php
/** 
 * @Author: whero 
 * @Date: 2018-05-26 17:42:17 
 * @Desc: 默认控制器 
 */
class IndexController extends Controller {

	/** 
	 * @Author: whero 
	 * @Date: 2018-05-26 17:45:05 
	 * @Desc: 默认动作 
	 */	
	public function indexAction() {
		// echo json_encode(['code'=>2,'data'=>1111]);
		// return false;
		$response = \Yaf\Registry::get('response');
		// $response->header('Content-Type', 'text/html;charset=utf-8');
        $response->status(404);
		// var_dump(opcache_get_status());
		$response->write(json_encode(['code'=>2,'data'=>1111]));
        // var_dump(opcache_get_status()['opcache_statistics']);
        // return false;
		$this->getView()->assign("content", "Hello World");
	}
}
