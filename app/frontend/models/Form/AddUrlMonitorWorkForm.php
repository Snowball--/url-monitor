<?php

declare(strict_types=1);

namespace frontend\models\Form;

use common\models\Forms\AddWorkFormInterface;
use common\models\Works\WorkType;
use yii\base\Model;

class AddUrlMonitorWorkForm extends Model implements AddWorkFormInterface
{
    public string $url = '';
    public int $frequency = 1;
    public int $onErrorRepeatCount = 0;
    public int $onErrorRepeatDelay = 0;

    public function rules(): array
    {
        return [
            ['url', 'required'],
            ['url', 'string', 'max' => 255],
            ['url', 'url', 'defaultScheme' => 'http'],
            ['frequency', 'in', 'range' => [1, 5, 10]],
            [['onErrorRepeatCount', 'onErrorRepeatDelay'], 'integer'],
        ];
    }

    public function getFrequency(): int
    {
        return (int) $this->frequency;
    }

    public function getOnErrorRepeatCount(): int
    {
        return (int) $this->onErrorRepeatCount;
    }

    public function getOnErrorRepeatDelay(): int
    {
        return (int) $this->onErrorRepeatDelay;
    }

    public function getAdditionalData(): array
    {
        return [
            'url' => $this->url
        ];
    }

    public function getType(): WorkType
    {
        return WorkType::URL;
    }
}
