<?php
declare(strict_types=1);

namespace common\models\Works;

enum WorkActivity: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;
}
