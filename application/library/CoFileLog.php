<?php

/**
 * 文件日志
 */

 class CoFileLog{

    private $log;

    public function __construct()
    {
        $this->log_path = \Yaf\Registry::get('config')['log']['path']. date( "Ym" ) . "/" . date( 'd' ) . ".log";

        $path = dirname($this->log_path);
        !is_dir($path) && mkdir($path, 0755, true);
    }
    /**
     * 打印日志
     * $logs 字符串
     */
    public function info($logs = "")
    {
		swoole_async_writefile( $this->log_path , $logs . PHP_EOL, function ( $filename ) {}, FILE_APPEND );
    }
    /**
     * 打印日志
     * $datas 数组
     */
    public function write($datas)
    {
        $logs  = "";
		foreach ( $datas as $key => $value ) {
			$logs .= $key . ":" . $value . " | ";
		}
		swoole_async_writefile( $this->log_path, $logs . PHP_EOL, function ( $filename ) {}, FILE_APPEND );
    }
 }