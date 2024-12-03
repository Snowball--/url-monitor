<?php

namespace common\models\Works;

/**
 * This is the model class for table "monitored_urls".
 *
 * @property int $id
 * @property string|null $url
 */
class MonitoredUrl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'monitored_urls';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
        ];
    }
}
