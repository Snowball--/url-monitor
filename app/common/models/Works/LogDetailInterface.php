<?php

namespace common\models\Works;

interface LogDetailInterface
{
    public function getLog(): WorkLog;

    public function getId(): ?int;

    public function setId(int $id);

    public function fillDetailWithData($data);
}
