<?php
declare(strict_types=1);

namespace common\models\Works\Processors;

use common\models\Jobs\JobInterface;
use common\models\WorkLogs\WorkLog;

interface JobProcessorInterface
{
    /**
     * @param JobInterface $job
     * @return WorkLog
     */
    public function process(JobInterface $job): WorkLog;
}
