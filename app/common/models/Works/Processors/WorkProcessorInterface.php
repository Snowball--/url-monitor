<?php
declare(strict_types=1);

namespace common\models\Works\Processors;

use common\models\WorkLogs\WorkLog;

interface WorkProcessorInterface
{
    public function process(WorkLog $job): void;
}