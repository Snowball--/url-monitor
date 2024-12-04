<?php
declare(strict_types=1);

use common\Services\WorkLogService;
use common\Services\WorkService;

return [
    'definitions' => [
        WorkService::class => WorkService::class,
        WorkLogService::class => WorkLogService::class
    ]
];