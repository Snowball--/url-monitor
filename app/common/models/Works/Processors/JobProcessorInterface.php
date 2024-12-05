<?php
declare(strict_types=1);

namespace common\models\Works\Processors;

use common\models\Jobs\JobInterface;

interface JobProcessorInterface
{
    public function process(JobInterface $job): void;
}