<?php

namespace common\models\Jobs;

use common\Enums\WorkType;
use common\models\Works\Work;

interface JobInterface
{
    public function getWork(): Work;
    public function getParams(): array;

    public function getType(): WorkType;
}
