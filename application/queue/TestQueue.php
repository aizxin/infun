<?php
/**
 * FileName: TestQueue.php
 * ==============================================
 * Copy right 2016-2017
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @author: kong | <iwhero@yeah.com>
 * @date  : 2019-07-06 11:42
 */

namespace App\Queue;


use swf\facade\Log;
use swf\queue\Job;

class TestQueue
{
    /**
     * fire方法是消息队列默认调用的方法
     * @param Job            $job      当前的任务对象
     * @param array|mixed    $data     发布任务时自定义的数据
     */
    public function fire(Job $job,$data){
        $isJobDone = $this->doOrderJob($data);
        var_dump($isJobDone);
        if ($isJobDone) {
            //如果任务执行成功， 记得删除任务
            $job->delete();
        }else{
            var_dump($job->attempts());
            if ($job->attempts() > 3) {

                //通过这个方法可以检查这个任务已经重试了几次了
                // 也可以重新发布这个任务
                $job->delete();
            } else {
                $job->release(); //$delay为延迟时间，表示该任务延迟2秒后再执行
            }
        }
    }
    /**
     * 根据消息中的数据进行实际的业务处理
     * @param array|mixed    $data     发布任务时自定义的数据
     * @return boolean                 任务执行的结果
     */
    public function doOrderJob($data) {
        // 根据消息中的数据进行实际的业务处理...
        Log::write('doOrderJob'.json_encode($data));
        return true;
    }
    /**
     * 该方法用于接收任务执行失败的通知，你可以发送邮件给相应的负责人员
     * @param $jobData  string|array|...      //发布任务时传递的 jobData 数据
     */
    public function failed($jobData){
        // send_mail_to_somebody() ;
        Log::write('ffffs'.json_encode($jobData));
    }
}