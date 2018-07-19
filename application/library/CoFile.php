<?php


/** 
 * @Author: whero 
 * @Date: 2018-07-19 22:22:23 
 * @Desc: 写文件 
 */

use Swoole\Coroutine;


class CoFile{

    use Instance;
    /** 
     * @Author: whero 
     * @Date: 2018-07-19 22:24:58 
     * @Desc: 写入大文件 
     */    
    public function writeFile($filename,$content)
    {
        $filename = APP_PATH.'/public/'.$filename;
        if(file_exists($filename)){
            return;
        }
        Coroutine::create(function () use ($filename,$content)
        {
            Coroutine::writeFile($filename,$content);
        });
    }
    /** 
     * @Author: whero 
     * @Date: 2018-07-19 22:27:32 
     * @Desc: 写入小文件 
     */    
    public function fwrite($filename,$content)
    {
        Coroutine::create(function () use ($filename,$content)
        {
            Coroutine::fwrite($filename,$content);
        });
    }


}