<?php
declare(strict_types=1);

namespace common\Services;

use common\Exceptions\ValidationException;
use common\models\WorkLogs\WorkLog;
use common\models\WorkLogs\WorkLogState;
use common\models\Works\Work;
use console\Forms\AddWorkLogForm;

/**
 * Class QueueService
 *
 * @author snowball <snow-snowball@yandex.ru>
 * @package common\Services
 */
class QueueService
{
    public function __construct(private readonly WorkLogService $workLogService)
    {

    }

    public function addJob(Work $work): void
    {
        $lastJob = $work->getLastJob();
        if (!$lastJob) {
            $log = $this->toQueue($work);
        }
    }

    /**
     * @throws ValidationException
     */
    private function toQueue(Work $work): WorkLog
    {
        $form = new AddWorkLogForm();
        $form->workId = $work->id;
        $form->state = WorkLogState::NEW;
        $form->attemptNumber = 1;

        return $this->workLogService->createLog($form);
    }
}