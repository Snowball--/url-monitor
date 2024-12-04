<?php

namespace common\models\WorkLogs;

/**
 * This is the model class for table "monitored_url_log_details".
 *
 * @property int $id
 * @property int $response_code
 * @property string|null $response_body
 */
class UrlLogDetail extends \yii\db\ActiveRecord implements LogDetailInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'monitored_url_log_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['response_code'], 'required'],
            [['response_code'], 'integer'],
            [['response_body'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'response_code' => 'Response Code',
            'response_body' => 'Response Body',
        ];
    }

    public function getLog(): WorkLog
    {
        /* @var WorkLog $log*/
        $log = $this->hasOne(WorkLog::class, ['id' => 'id'])->one();
        return $log;
    }
}
