<?php

namespace common\models\WorkLogs;

use common\Enums\WorkType;
use common\models\WorkLogs\ActiveQuery\WorkLogQuery;
use common\models\Works\FitForJobInterface;
use common\models\Works\Work;
use DateTimeImmutable;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "work_logs".
 *
 * @property int $id
 * @property int|null $work_id
 * @property string|null $date_created
 * @property string|null $state
 * @property int|null $attempt_number
 */
class WorkLog extends ActiveRecord implements FitForJobInterface
{
    private ?DateTimeImmutable $dateCreated = null;

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
            [['date_created', 'state'], 'safe'],
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

    public function getState(): WorkLogState
    {
        return WorkLogState::fromValue($this->state);
    }

    public function getWork(): Work
    {
        /* @var Work $work */
        $work = $this->hasOne(Work::class, ['id' => 'work_id'])->one();
        return $work;
    }

    public function getDetails(): array|ActiveRecord|null
    {
        $work = $this->getWork();
        return $this->hasOne($work->getType()->getLogDetailsClass(), ['id' => 'id'])->one();
    }

    public function getDateCreated(): DateTimeImmutable
    {
        return $this->dateCreated;
    }

    public function beforeSave($insert): bool
    {
        if ($insert) {
            $this->date_created = date('Y-m-d H:i:s');
        }

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->dateCreated = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->date_created);
        parent::afterFind();
    }

    public static function find(): WorkLogQuery
    {
        return new WorkLogQuery(static::class);
    }

    public function getWorkId(): int
    {
        $this->work_id;
    }

    public function getType(): WorkType
    {
        return $this->getWork()->getType();
    }

    public function getAttemptNumber(): int
    {
        return $this->attempt_number;
    }
}
