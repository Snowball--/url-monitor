<?php
declare(strict_types=1);

namespace common\Enums;

enum WorkLogState: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case SUCCESS = 'success';
    case FAIL = 'fail';

    public static function fromValue(string $value): self
    {
        return match ($value) {
            self::NEW->value => self::NEW,
            self::IN_PROGRESS->value => self::IN_PROGRESS,
            self::SUCCESS->value => self::SUCCESS,
            self::FAIL->value => self::FAIL,
            default => throw new \DomainException('Unknown state ' . $value)
        };
    }
}
