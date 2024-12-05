<?php

namespace common\models\Jobs;

/**
 * This is the model class for table "jobs".
 *
 * @property int $id
 * @property int $work_id
 * @property string|null $params
 */
class JobActiveRecord extends \yii\db\ActiveRecord
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
            [['work_id'], 'required'],
            [['work_id'], 'integer'],
            [['params'], 'string'],
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
}
