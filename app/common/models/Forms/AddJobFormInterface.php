<?php
declare(strict_types=1);

namespace common\models\Forms;

interface AddJobFormInterface
{
    public function getWorkId(): int;
    public function getParams(): array;
}
