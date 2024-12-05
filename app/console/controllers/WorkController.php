<?php
declare(strict_types=1);

namespace console\controllers;

use common\models\WorkLogs\WorkLog;
use common\models\Works\Processors\UrlMonitorProcessor;
use common\models\Works\Work;
use common\Services\Queue\QueueService;
use yii\console\Controller;

/**
 * Class WorkController
 *
 * @author snowball <snow-snowball@yandex.ru>
 * @package controllers
 */
class WorkController extends Controller
{
    /**
     * Fill queue with work jobs
     *
     * @param QueueService $queueService
     * @return void
     */
    public function actionQueue(QueueService $queueService): void
    {
        foreach (Work::find()->allActive()->each() as $work) {
            $queueService->addJob($work);
        }
    }

    public function actionRun(): void
    {
        $processor = new UrlMonitorProcessor();
        foreach (WorkLog::find()->allNew()->all() as $workLog) {
            $processor->process($workLog);
        }
    }
}