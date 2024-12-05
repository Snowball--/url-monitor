<?php
declare(strict_types=1);

use common\models\Works\Processors\JobProcessorInterface;
use common\models\Works\Processors\UrlMonitorProcessor;
use common\Services\Queue\QueueDataProvider\BaseDataProvider;
use common\Services\Queue\QueueDataProvider\QueueDataProviderInterface;
use common\Services\Queue\QueueService;
use common\Services\WorkLogService;
use common\Services\WorkService;

return [
    'definitions' => [
        WorkService::class => WorkService::class,
        WorkLogService::class => WorkLogService::class,
        QueueService::class => QueueService::class,
        QueueDataProviderInterface::class => BaseDataProvider::class,
        JobProcessorInterface::class => UrlMonitorProcessor::class
    ]
];