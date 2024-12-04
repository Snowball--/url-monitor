<?php
declare(strict_types=1);

namespace common\models\Forms;

use common\models\WorkLogs\WorkLogState;

interface AddWorkLogFormInterface
{
    public function getWorkId(): int;
    public function getState(): WorkLogState;
    public function getAttemptNumber(): int;
}
