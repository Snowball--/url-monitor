<?php
declare(strict_types=1);

namespace common\models\Works\Processors;

use common\models\Works\JobInterface;
use common\models\Works\WorkLog;

interface JobProcessorInterface
{
    /**
     * @param JobInterface $job
     * @return WorkLog
     */
    public function process(JobInterface $job): WorkLog;
}
