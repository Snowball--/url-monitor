<?php

namespace common\models\WorkLogs;

use common\models\WorkLogs\ActiveQuery\WorkLogQuery;
use common\models\Works\Work;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "work_logs".
 *
 * @property int $id
 * @property int|null $work_id
 * @property string|null $date_created
 * @property string|null $date_processed
 * @property string|null $state
 * @property int|null $attempt_number
 */
class WorkLog extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'work_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['work_id', 'attempt_number'], 'integer'],
            [['date_created', 'state', 'date_processed'], 'safe'],
            [['state'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'work_id' => 'Work ID',
            'date_created' => 'Date Time',
            'state' => 'State',
            'attempt_number' => 'Attempt Number',
        ];
    }

    public function getWork(): ActiveQuery
    {
        return $this->hasOne(Work::class, ['id' => 'work_id']);
    }

    public function getDetails(): array|ActiveRecord|null
    {
        /* @var Work $work */
        $work = $this->getWork()->one();
        return $this->hasOne($work->getType()->getLogDetailsClass(), ['id', 'id'])->one();
    }

    public function beforeSave($insert): bool
    {
        if ($insert) {
            $this->date_created = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }

    public static function find(): WorkLogQuery
    {
        return new WorkLogQuery(static::class);
    }
}
