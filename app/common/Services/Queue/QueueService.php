<?php
declare(strict_types=1);

namespace common\Services\Queue;

use common\Exceptions\ValidationException;
use common\models\Jobs\JobInterface;
use common\models\WorkLogs\WorkLog;
use common\models\WorkLogs\WorkLogState;
use common\models\Works\FitForJobInterface;
use common\models\Works\Work;
use common\Services\JobService;
use common\Services\Queue\QueueDataProvider\QueueDataProviderInterface;
use console\models\Forms\AddJobForm;
use DateTime;
use Throwable;
use Yii;
use yii\caching\CacheInterface;
use yii\db\Exception;
use yii\db\StaleObjectException;
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
    public function toQueue(FitForJobInterface $data): JobInterface
    {
        try {
            $form = new AddJobForm();
            $form->workId = $data->getWorkId();
            $form->params = [
                'type' => $data->getType()->value,
                'attempt_number' => $data->getAttemptNumber() + 1,
                'details' => $data->getDetails()
            ];

            $job = $this->jobService->create($form);
            $this->cache->set($data->getWorkId());
        } catch (Throwable $e) {
            Yii::$app->log->logger->log($e->getMessage(), Logger::LEVEL_ERROR);
            throw $e;
        }

        return $job;
    }

    /**
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function removeFromQueue(JobInterface $job): false|int
    {
        return $this->jobService->delete($job);
    }

    public function all(): \Generator
    {
        return $this->jobService->getAll();
    }
}