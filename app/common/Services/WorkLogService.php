<?php
declare(strict_types=1);

namespace common\Services;

use common\Exceptions\ValidationException;
use common\models\Forms\AddWorkLogFormInterface;
use common\models\WorkLogs\WorkLog;

/**
 * Class WorkLogService
 *
 * @author snowball <snow-snowball@yandex.ru>
 * @package common\Services
 */
class WorkLogService
{
    public function createLog(AddWorkLogFormInterface $form): WorkLog
    {
        $log = new WorkLog();
        $log->work_id = $form->getWorkId();
        $log->state = $form->getState()->value;
        $log->attempt_number = $form->getAttemptNumber();

        if (!$log->save()) {
            throw new ValidationException($log);
        }

        return $log;
    }
}