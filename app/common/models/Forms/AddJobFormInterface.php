<?php
declare(strict_types=1);

namespace common\models\Forms;

use common\models\WorkLogs\WorkLogState;

interface AddJobFormInterface
{
    public function getWorkId(): int;
    public function getParams(): array;
}
