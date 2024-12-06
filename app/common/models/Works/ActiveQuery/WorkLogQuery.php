<?php
declare(strict_types=1);

namespace common\models\Works\ActiveQuery;

use common\Enums\WorkLogState;
use common\models\Works\Work;
use yii\db\ActiveQuery;

/**
 * Class WorkLogQuery
 *
 * @author snowball <snow-snowball@yandex.ru>
 * @package common\models\WorkLogs\ActiveQuery
 */
class WorkLogQuery extends ActiveQuery
{
    public function allActiveForWork(Work $work): self
    {
        return $this->andWhere(['work_id' => $work->id])
            ->andWhere(['in', 'state', [WorkLogState::IN_PROGRESS, WorkLogState::NEW]]);
    }

    public function lastForWork(Work $work): self
    {
        return $this->andWhere(['work_id' => $work->id])
            ->orderBy(['id' => SORT_DESC]);
    }

    public function allNew(): self
    {
        return $this->andWhere(['state' => WorkLogState::NEW]);
    }
}
