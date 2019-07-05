<?php
/**
 * FileName: TestProcess.php
 * ==============================================
 * Copy right 2016-2017
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @author: kong | <iwhero@yeah.com>
 * @date  : 2019-07-03 22:01
 */

namespace App\Process;


use swf\facade\Log;
use swf\process\AbstractProcess;

class TestProcess extends AbstractProcess
{
    public $name = 'test_process';

    public function handle(): void
    {
        var_dump('TestProcess'.time());
    }


}