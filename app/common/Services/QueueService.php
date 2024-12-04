<?php
declare(strict_types=1);

namespace common\Services;

use common\Exceptions\ValidationException;
use common\models\WorkLogs\WorkLog;
use common\models\WorkLogs\WorkLogState;
use common\models\Works\Work;
use console\models\Forms\AddWorkLogForm;
use DateTime;

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
        if ($this->needToQueue($work)) {
            $log = $this->toQueue($work);
        }
    }

    private function needToQueue(Work $work): bool
    {
        $needToQueue = false;
        $lastJob = $work->getLastJob();
        if (!$lastJob) {
            $needToQueue = true;
        }

        $nowDate = new Datetime('now');
        if ($lastJob->getState() === WorkLogState::SUCCESS
            && $lastJob->getDateProcessed() < $nowDate->add(
                \DateInterval::createFromDateString("-{$work->frequency} minutes")
            )
        ) {
            $needToQueue = true;
        }

        if ($lastJob->getState() === WorkLogState::FAIL
            && $lastJob->attempt_number < $work->on_error_repeat_count
            && $lastJob->getDateProcessed() < $nowDate->add(
                \DateInterval::createFromDateString("-{$work->on_error_repeat_delay} minutes")
            )
        ) {
            $needToQueue = true;
        }

        return $needToQueue;
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