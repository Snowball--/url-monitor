<?php
declare(strict_types=1);

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
        QueueDataProviderInterface::class => BaseDataProvider::class
    ]
];