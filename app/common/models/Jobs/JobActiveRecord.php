<?php

declare(strict_types=1);

namespace common\models\Jobs;

use common\models\Works\Work;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "jobs".
 *
 * @property int $id
 * @property int $work_id
 * @property string|null $params
 */
class JobActiveRecord extends ActiveRecord implements JobInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['work_id', 'params'], 'required'],
            [['work_id'], 'integer'],
            ['params', function($attribute, $params) {
                $attributeValue = $this->$attribute;
                if (!is_array($attributeValue)) {
                    $this->addError($attribute, "Атрибут $attribute должен быть массивом");
                }

                if (!isset($attributeValue['type'])) {
                    $this->addError($attribute, "Атрибут $attribute должен содержать ключ 'type'");
                }
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'work_id' => 'Work ID',
            'params' => 'Params',
        ];
    }

    public function beforeSave($insert): bool
    {
        $this->params = Json::encode($this->params);
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->params = Json::decode($this->params);
        parent::afterFind();
    }

    public function getWork(): Work
    {
        return $this->hasOne(Work::class, ['id' => 'work_id'])->one();
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
