<?php

namespace common\Enums;

use common\models\WorkLogs\UrlLogDetail;
use common\models\Works\MonitoredUrl;

enum WorkType: string
{
    case URL = 'url';

    public function getExtendedEntityClass(): string
    {
        return match ($this) {
            WorkType::URL => MonitoredUrl::class
        };
    }

    public function getLogDetailsClass(): string
    {
        return match ($this) {
            WorkType::URL => UrlLogDetail::class
        };
    }

    public static function getTypeFromValue(string $type): WorkType
    {
        return match ($type) {
            WorkType::URL->value => WorkType::URL,
            default => throw new \UnexpectedValueException("Unknown work type $type")
        };
    }
}
