<?php
declare(strict_types=1);

namespace common\Services;

use common\Exceptions\ValidationException;
use common\models\Forms\AddJobFormInterface;
use common\models\Forms\AddWorkLogFormInterface;
use common\models\WorkLogs\WorkLog;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\log\Logger;

/**
 * Class WorkLogService
 *
 * @author snowball <snow-snowball@yandex.ru>
 * @package common\Services
 */
class WorkLogService
{
    /**
     * @throws Throwable
     * @throws Exception
     * @throws ValidationException
     */
    public function createLog(AddWorkLogFormInterface $form): WorkLog
    {
        try {
            $log = new WorkLog();
            $log->work_id = $form->getWorkId();
            $log->state = $form->getState()->value;
            $log->attempt_number = $form->getAttemptNumber();

            if (!$log->save()) {
                throw new ValidationException($log);
            }
            $form->writeDetailedData($log);
        } catch (Throwable $e) {
            Yii::$app->log->logger->log($e->getMessage(), Logger::LEVEL_ERROR);
            throw $e;
        }

        return $log;
    }
}