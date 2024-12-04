<?php

namespace common\models\WorkLogs;

interface LogDetailInterface
{
    public function getLog(): WorkLog;

    public function getId(): ?int;

    public function setId(int $id);
}
