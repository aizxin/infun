<?php

/**
 * 文件日志
 */

 class CoFileLog{

    private $log;

    public function __construct()
    {
        $this->log = \Yaf\Registry::get('config')['log']['path'];
    }
    /**
     * 打印日志
     * $logs 字符串
     */
    public function info($logs = "")
    {
        // return $this->log . date( "Ym" ) . "/" . date( 'd' ) . ".log";
		swoole_async_writefile( $this->log . date( "Ym" ) . "/" . date( 'd' ) . ".log", $logs . PHP_EOL, function ( $filename ) {}, FILE_APPEND );
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
		swoole_async_writefile( $this->log. date( "Ym" ) . "/" . date( 'd' ) . ".log", $logs . PHP_EOL, function ( $filename ) {}, FILE_APPEND );
    }
 }