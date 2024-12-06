<?php

namespace common\models\Works\Processors;

use common\Enums\WorkType;
use common\models\Works\JobInterface;

class JobProcessorFactory
{
    public static function factory(JobInterface $job): JobProcessorInterface
    {
        return match ($job->getType()) {
            WorkType::URL => \Yii::$container->get(UrlMonitorProcessor::class)
        };
    }
}
