<?php
declare(strict_types=1);

namespace console\models\Forms;

use common\models\Forms\AddJobFormInterface;
use common\models\WorkLogs\WorkLogState;
use yii\base\Model;

/**
 * Class AddJobForm
 *
 * @author snowball <snow-snowball@yandex.ru>
 * @package console\Forms
 */
class AddJobForm extends Model implements AddJobFormInterface
{
    public int $workId;
    public array $params;

    public function getWorkId(): int
    {
        return $this->workId;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
