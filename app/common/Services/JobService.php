<?php

namespace common\Services;

use common\Exceptions\ValidationException;
use common\models\Forms\AddJobFormInterface;
use common\models\Jobs\JobActiveRecord;
use common\models\Jobs\JobInterface;
use yii\base\Model;
use yii\db\Exception;

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
}