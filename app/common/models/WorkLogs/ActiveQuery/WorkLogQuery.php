<?php
declare(strict_types=1);

namespace common\models\WorkLogs\ActiveQuery;

use common\models\WorkLogs\WorkLogState;
use common\models\Works\Work;

/**
 * Class WorkLogQuery
 *
 * @author snowball <snow-snowball@yandex.ru>
 * @package common\models\WorkLogs\ActiveQuery
 */
class WorkLogQuery extends \yii\db\ActiveQuery
{
    public function allActiveForWork(Work $work): self
    {
        return $this->andWhere(['work_id' => $work->id])
            ->andWhere(['in', 'state', [WorkLogState::IN_PROGRESS, WorkLogState::NEW]]);
    }
}