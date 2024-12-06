<?php

namespace common\models\Works;

use common\Enums\WorkType;

interface FitForJobInterface
{
    public function getWorkId(): int;
    public function getType(): WorkType;
    public function getAttemptNumber(): int;

    public function getDetails(): array;
}
