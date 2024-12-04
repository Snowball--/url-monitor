<?php
declare(strict_types=1);

namespace common\models\WorkLogs;

enum WorkLogState: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case SUCCESS = 'success';
    case FAIL = 'fail';
}
