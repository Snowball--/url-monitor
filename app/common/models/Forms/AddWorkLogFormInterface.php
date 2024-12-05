<?php

namespace common\models\Forms;

use common\models\WorkLogs\LogDetailInterface;
use common\models\WorkLogs\WorkLog;
use common\models\WorkLogs\WorkLogState;

interface AddWorkLogFormInterface
{
    public function getWorkId(): int;

    public function getState(): WorkLogState;

    public function getAttemptNumber(): int;

    public function writeDetailedData(WorkLog $log): LogDetailInterface;
}
