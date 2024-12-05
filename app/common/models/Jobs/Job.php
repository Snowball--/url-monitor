<?php

namespace common\models\Jobs;

use common\models\Works\Work;
use yii\base\Model;

class Job extends Model implements JobInterface
{
    public int $work_id;
    public array $params;

    public function getWork(): Work
    {
        $work = Work::find()->byId($this->work_id);
        if (!$work) {
            throw new \DomainException("Can't get work with id {$this->work_id}");
        }
        return $work;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
