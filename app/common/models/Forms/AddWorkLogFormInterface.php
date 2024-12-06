<?php

namespace common\models\Forms;

use common\Enums\WorkLogState;
use common\models\Works\LogDetails\LogDetailInterface;
use common\models\Works\WorkLog;

interface AddWorkLogFormInterface
{
    public function getWorkId(): int;

    public function getState(): WorkLogState;

    public function getAttemptNumber(): int;

    public function getDetailedData(): mixed;

    public function writeDetailedData(WorkLog $log): ?LogDetailInterface;
}
