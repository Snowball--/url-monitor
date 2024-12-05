<?php

namespace common\models\Works;

use common\Enums\WorkType;
use common\models\WorkLogs\WorkLog;
use common\models\Works\ActiveQuery\WorkQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "works".
 *
 * @property int $id
 * @property string $type
 * @property int|null $frequency
 * @property int|null $on_error_repeat_count
 * @property int|null $on_error_repeat_delay
 * @property string|null $date_created
 * @property int|null $is_active
 */
class Work extends ActiveRecord
{
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'works';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['type'], 'required'],
            [['frequency', 'on_error_repeat_count', 'on_error_repeat_delay', 'is_active'], 'integer'],
            [['date_created'], 'safe'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'frequency' => 'Frequency',
            'on_error_repeat_count' => 'On Error Repeat Count',
            'on_error_repeat_delay' => 'On Error Repeat Delay',
            'date_created' => 'Date Created',
            'is_active' => 'Is Active',
        ];
    }

    public function getType(): WorkType
    {
        return WorkType::getType($this->type);
    }

    public function getExtendedEntity(): ActiveRecord|ExtendedWorkEntityInterface
    {
        return $this->hasOne($this->getType()->getExtendedEntityClass(), ['id' => 'id'])->one();
    }

    public function getLastLog(): ?WorkLog
    {
        /* @var WorkLog $lastLog */
        $lastLog = WorkLog::find()->lastForWork($this)->one();
        return $lastLog;
    }

    public function beforeSave($insert): bool
    {
        if ($insert) {
            $this->date_created = date('Y-m-d H:i:s');
        }

        return parent::beforeSave($insert);
    }

    public static function find(): WorkQuery
    {
        return new WorkQuery(static::class);
    }
}
