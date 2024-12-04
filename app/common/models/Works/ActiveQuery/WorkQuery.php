<?php
declare(strict_types=1);

namespace common\models\Works\ActiveQuery;

use common\models\WorkLogs\WorkLog;
use common\models\WorkLogs\WorkLogState;
use common\models\Works\WorkActivity;
use yii\db\ActiveQuery;

/**
 * Class WorkQuery
 *
 * @author snowball <snow-snowball@yandex.ru>
 * @package common\models\Works\ActiveQuery
 */
class WorkQuery extends ActiveQuery
{

    public function allActive(): self
    {
        return $this->where(['is_active' => WorkActivity::ACTIVE]);
    }
}