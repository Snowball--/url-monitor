<?php

namespace console\models\Forms;

use common\Exceptions\ValidationException;
use common\models\Forms\AddWorkLogFormInterface;
use common\models\WorkLogs\LogDetailInterface;
use common\models\WorkLogs\WorkLog;
use common\models\WorkLogs\WorkLogState;
use Psr\Http\Message\ResponseInterface;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\Exception;

class AddWorkLogForm extends Model implements AddWorkLogFormInterface
{
    public int $workId;
    public WorkLogState $state;
    public int $attemptNumber;

    public mixed $detailedData = null;

    public function getWorkId(): int
    {
        return $this->workId;
    }

    public function getState(): WorkLogState
    {
        return $this->state;
    }

    public function getAttemptNumber(): int
    {
        return $this->attemptNumber;
    }

    public function getDetailedData(): mixed
    {
        return $this->detailedData;
    }

    /**
     * @throws Exception
     * @throws ValidationException
     */
    public function writeDetailedData(WorkLog $log): ?LogDetailInterface
    {
        $entity = null;
        if ($this->getDetailedData() instanceof ResponseInterface) {
            $detailsClass = $log->getWork()->getType()->getLogDetailsClass();
            /* @var LogDetailInterface&ActiveRecord $entity */
            $entity = new $detailsClass();
            $entity->setId($log->id);
            $entity->fillDetailWithData($this->getDetailedData());

            if (!$entity->save()) {
                throw new ValidationException($entity);
            }
        }

        return $entity;
    }

}