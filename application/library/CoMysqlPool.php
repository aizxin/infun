<?php
/** 
 * @Author: whero 
 * @Date: 2018-05-26 17:40:39 
 * @Desc: mysql连接池 
 */
class CoMysqlPool
{
    public $chan;
    public function __construct()
    {
        $this->chan = new chan(1024);
    }
    public function push($mysql)
    {
        $this->chan->push($mysql);
    }
    public function pop()
    {
        //有空闲连接
        if ($this->chan->stats()['queue_num'] > 0)
        {
            return $this->chan->pop();
        } else {
            //无空闲连接，创建新连接
            $mysql = new \Swoole\Coroutine\MySQL();
            $config = \Yaf\Registry::get('config')->toArray();
            $mysql->connect($config['db']);
            return $mysql;
        }
    }
}