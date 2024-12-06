<?php

namespace common\Services\Queue\QueueDataProvider;

use common\models\Works\JobInterface;

interface QueueDataProviderInterface
{
    public function pop(): JobInterface;

    public function push(JobInterface $job);
}
