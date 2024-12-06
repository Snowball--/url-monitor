<?php

namespace common\models\Works;

use common\Enums\WorkType;

interface JobInterface
{
    public function getWork(): Work;
    public function getParams(): array;

    public function getType(): WorkType;
}
