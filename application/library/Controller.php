<?php
/**
 * @Author: whero
 * @Date: 2018-05-26 17:28:30
 * @Desc: 控制器
 */
class Controller extends \Yaf\Controller_Abstract{
    /**
     * @Author: whero
     * @Date: 2018-05-26 17:29:38
     * @Desc:swoole的服务
     */
    public function server()
    {
        return \Yaf\Registry::get('http');
    }
    /**
     * @Author: whero
     * @Date: 2018-05-26 17:31:39
     * @Desc: get请求的数据
     */
    public function get()
    {
        return \Yaf\Registry::get('request')->get;
        // \Yaf\Registry::set('response', $response);
    }
    /**
     * @Author: whero
     * @Date: 2018-05-26 17:33:27
     * @Desc: post请求的数据
     */
    public function post()
    {
        return \Yaf\Registry::get('request')->post;
    }
    /**
     * @Author: whero
     * @Date: 2018-05-26 17:34:27
     * @Desc: 文件上传的数据
     */
    public function files()
    {
        return \Yaf\Registry::get('request')->files;
    }
    /**
     * @Author: whero
     * @Date: 2018-05-26 17:36:00
     * @Desc: 请求数据
     */
    public function request()
    {
        return \Yaf\Registry::get('request');
    }
    /**
     * @Author: whero
     * @Date: 2018-05-26 17:43:34
     * @Desc: 响应
     */
    public function response()
    {
        return \Yaf\Registry::get('response');
    }
    /**
     * @Author: whero
     * @Date: 2018-06-01 23:02:07
     * @Desc: 获取html
     */
    public function getHtml()
    {
        return \Yaf\Registry::get('html');
    }
    /**
     * @Author: whero
     * @Date: 2018-06-01 23:03:51
     * @Desc: 渲染视图
     */
    public function getRender($file)
    {

    }
}