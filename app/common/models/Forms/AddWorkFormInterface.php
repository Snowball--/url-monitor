<?php
declare(strict_types=1);

namespace common\models\Forms;

use common\models\Works\WorkType;

interface AddWorkFormInterface
{
    public function getType(): WorkType;

    public function getFrequency(): int;

    public function getOnErrorRepeatCount(): int;

    public function getOnErrorRepeatDelay(): int;

    public function getAdditionalData(): array;
}
