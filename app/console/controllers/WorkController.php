<?php
declare(strict_types=1);

namespace console\controllers;

use common\models\Works\Work;
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
     * @return void
     */
    public function actionQueue()
    {
        Work::find()->allActive()->each(function (Work $work) {
            if (!$work->hasActiveJob()) {

            }
        });
    }
}