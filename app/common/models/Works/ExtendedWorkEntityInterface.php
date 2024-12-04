<?php
declare(strict_types=1);

namespace common\models\Works;

interface ExtendedWorkEntityInterface
{
    public function getId(): int;
    public function setId(int $id): void;
}
