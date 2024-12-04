<?php

namespace frontend\models\Form;

use yii\base\Model;

class AddUrlMonitorWorkForm extends Model
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
}