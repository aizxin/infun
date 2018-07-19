<?php


/** 
 * @Author: whero 
 * @Date: 2018-07-19 22:29:54 
 * @Desc: 单列初始化 
 */
trait Instance
{
    protected static $instance = null;

    /**
     * @param array $options
     * @return static
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /** 
     * @Author: whero 
     * @Date: 2018-07-19 22:30:29 
     * @Desc: 静态调用 
     */    
    public static function __callStatic($method, $params)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        $call = substr($method, 1);
        if (0 === strpos($method, '_') && is_callable([self::$instance, $call])) {
            return call_user_func_array([self::$instance, $call], $params);
        } else {
            throw new \Exception("method not exists:" . $method);
        }
    }
}