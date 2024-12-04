<?php

namespace common\models\WorkLogs;

use common\models\Works\Work;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "work_logs".
 *
 * @property int $id
 * @property int|null $work_id
 * @property string|null $date_time
 * @property string|null $state
 * @property int|null $attempt_number
 */
class WorkLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'work_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['work_id', 'attempt_number'], 'integer'],
            [['date_time'], 'safe'],
            [['state'], 'string', 'max' => 255],
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
            'date_time' => 'Date Time',
            'state' => 'State',
            'attempt_number' => 'Attempt Number',
        ];
    }

    public function getWork(): ActiveQuery
    {
        return $this->hasOne(Work::class, ['id' => 'work_id']);
    }

    public function getDetails()
    {
        /* @var Work $work */
        $work = $this->getWork()->one();
        return $this->hasOne($work->getType()->getLogDetailsClass(), ['id', 'id'])->one();
    }
}
