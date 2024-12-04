<?php

namespace common\models\WorkLogs;

interface LogDetailInterface
{
    public function getLog(): WorkLog;
}
