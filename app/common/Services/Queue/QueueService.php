<?php
declare(strict_types=1);

namespace common\Services\Queue;

use common\Exceptions\ValidationException;
use common\models\Jobs\JobInterface;
use common\models\WorkLogs\WorkLog;
use common\models\WorkLogs\WorkLogState;
use common\models\Works\Work;
use common\Services\JobService;
use common\Services\Queue\QueueDataProvider\QueueDataProviderInterface;
use console\models\Forms\AddJobForm;
use DateTime;
use Throwable;
use Yii;
use yii\caching\CacheInterface;
use yii\db\Exception;
use yii\log\Logger;

/**
 * Class QueueService
 *
 * @author snowball <snow-snowball@yandex.ru>
 * @package common\Services
 */
class QueueService
{
    private CacheInterface $cache;

    public function __construct(
        private readonly JobService $jobService
    ) {
        $this->cache = Yii::$app->cache;
    }

    public function addJob(Work $work): void
    {
        if ($this->needToQueue($work)) {
            $log = $this->toQueue($work);
        }
    }

    public function pop(): \Generator
    {
        foreach ($this->jobService->getAll() as $job) {
            yield $job;
        }

    }

    private function needToQueue(Work $work): bool
    {
        if ($this->cache->get($work->id)) {
            return false;
        }
        
        $needToQueue = false;
        $lastLog = $work->getLastLog();
        if (!$lastLog) {
            return true;
        }

        $nowDate = new Datetime('now');
        if ($lastLog->getDateCreated() < $nowDate->add(
            \DateInterval::createFromDateString("-{$work->frequency} minutes")
            )
        ) {
            $needToQueue = true;
        } elseif ($lastLog->getState() === WorkLogState::FAIL
            && $lastLog->attempt_number < $work->on_error_repeat_count
            && $lastLog->getDateCreated() < $nowDate->add(
                \DateInterval::createFromDateString("-{$work->on_error_repeat_delay} minutes")
            )
        ) {
            $needToQueue = true;
        }

        return $needToQueue;
    }

    /**
     * @throws ValidationException|Exception
     * @throws Throwable
     */
    private function toQueue(Work $work): JobInterface
    {
        try {
            $form = new AddJobForm();
            $form->workId = $work->id;
            $form->params = [
                'type' => $work->getType()->value,
                'attempt_number' => 1,
                'details' => $work->getExtendedEntity()?->getDetails()
            ];

            $job = $this->jobService->create($form);
            $this->cache->set($work->id, true);
        } catch (Throwable $e) {
            Yii::$app->log->logger->log($e->getMessage(), Logger::LEVEL_ERROR);
            throw $e;
        }

        return $job;
    }
}