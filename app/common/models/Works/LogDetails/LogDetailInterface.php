<?php

namespace common\models\Works\LogDetails;

use common\models\Works\WorkLog;

interface LogDetailInterface
{
    public function getLog(): WorkLog;

    public function getId(): ?int;

    public function setId(int $id);

    public function fillDetailWithData($data);
}
