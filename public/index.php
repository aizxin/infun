<?php

// 报错误信息 线上要注释
ini_set('display_errors','On');
error_reporting(E_ALL);
/**
 * @name 框架入口
 * @author Sow
 */
define('APP_PATH', dirname(__DIR__));
$application = new \Yaf\Application( APP_PATH . "/conf/application.ini");
$application->bootstrap()->run();

?>