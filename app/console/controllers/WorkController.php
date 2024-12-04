<?php
declare(strict_types=1);

namespace console\controllers;

use common\models\Works\Work;
use common\Services\QueueService;
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
}