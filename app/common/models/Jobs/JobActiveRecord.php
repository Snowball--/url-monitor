<?php

declare(strict_types=1);

namespace common\models\Jobs;

use common\Enums\WorkType;
use common\models\Jobs\ActiveQuery\JobQuery;
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
        /* @var Work $work */
        $work = $this->hasOne(Work::class, ['id' => 'work_id'])->one();
        return $work;
    }

    public function getParams(): array
    {
        /* @var array $params */
        $params = $this->params;
        return $params;
    }

    public static function find(): JobQuery
    {
        return new JobQuery(JobActiveRecord::class);
    }

    public function getType(): WorkType
    {
        $type = $this->getParams()['type'] ?? $this->getWork()->getType()->value;
        return WorkType::getTypeFromValue($type);
    }
}
