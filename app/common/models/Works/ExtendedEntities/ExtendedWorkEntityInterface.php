<?php
declare(strict_types=1);

namespace common\models\Works\ExtendedEntities;

interface ExtendedWorkEntityInterface
{
    public function getId(): int;
    public function setId(int $id): void;

    public function getDetails(): array;
}
