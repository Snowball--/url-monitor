<?php
declare(strict_types=1);

namespace console\Forms;

use common\models\Forms\AddWorkLogFormInterface;
use common\models\WorkLogs\WorkLogState;
use yii\base\Model;

/**
 * Class AddWorkLogForm
 *
 * @author snowball <snow-snowball@yandex.ru>
 * @package console\Forms
 */
class AddWorkLogForm extends Model implements AddWorkLogFormInterface
{
    public WorkLogState $state = WorkLogState::NEW;
    public int $workId;
    public int $attemptNumber;

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
}