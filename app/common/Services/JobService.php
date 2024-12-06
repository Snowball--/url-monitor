<?php

namespace common\Services;

use common\Exceptions\ValidationException;
use common\models\Forms\AddJobFormInterface;
use common\models\Works\JobActiveRecord;
use common\models\Works\JobInterface;
use Generator;
use Throwable;
use yii\base\Model;
use yii\db\Exception;
use yii\db\StaleObjectException;

class JobService extends Model
{
    /**
     * @throws Exception
     * @throws ValidationException
     */
    public function create(AddJobFormInterface $form): JobInterface
    {
        $job = new JobActiveRecord();
        $job->work_id = $form->getWorkId();
        $job->params = $form->getParams();

        if (!$job->save()) {
            throw new ValidationException($job);
        }

        return $job;
    }

    /**
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function delete(JobActiveRecord $job): false|int
    {
        return $job->delete();
    }

    public function getAll(): Generator
    {
        foreach (JobActiveRecord::find()->each() as $job) {
            yield $job;
        }
    }
}
