<?php
/** 
 * @Author: whero 
 * @Date: 2018-05-26 17:40:50 
 * @Desc: redis连接池 
 */
class CoRedisPool
{
    public $chan;
    public function __construct()
    {
        $this->chan = new chan(1024);
    }
    public function push($redis)
    {
        $this->chan->push($redis);
    }
    public function pop()
    {
        //有空闲连接
        if ($this->chan->stats()['queue_num'] > 0)
        {
            return $this->chan->pop();
        } else {
            //无空闲连接，创建新连接
            $redis = new Swoole\Coroutine\Redis();
            $config = \Yaf\Registry::get('config');
            $res = $redis->connect($config['redis']['host'], $config['redis']['port']);
            if(isset($config['redis']['auth']) && !empty($config['redis']['auth'])){
                $redis->auth($config['redis']['auth']);
            }
            if ($res == false) {
                return $this->pop();
            }
            return $redis;
        }
    }
}