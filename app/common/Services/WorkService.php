<?php
declare(strict_types=1);

namespace common\Services;

use common\Exceptions\ValidationException;
use common\models\Forms\AddWorkFormInterface;
use common\models\Works\ExtendedEntities\ExtendedWorkEntityInterface;
use common\models\Works\Work;
use Throwable;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * Class WorkService
 *
 * @author snowball <snow-snowball@yandex.ru>
 * @package common\Services
 */
class WorkService
{
    /**
     * @throws Exception
     * @throws Throwable
     */
    public function addWork(AddWorkFormInterface $form): Work
    {
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $work = new Work();
            $work->type = $form->getType()->value;
            $work->frequency = $form->getFrequency();
            $work->on_error_repeat_count = $form->getOnErrorRepeatCount();
            $work->on_error_repeat_delay = $form->getOnErrorRepeatDelay();

            if (!$work->save()) {
                throw new ValidationException($work);
            }

            $extendedEntityClass = $form->getType()->getExtendedEntityClass();
            /* @var ExtendedWorkEntityInterface&ActiveRecord $extendedEntity */
            $extendedEntity = new $extendedEntityClass();
            $extendedEntity->load($form->getAdditionalData(), '');
            $extendedEntity->setId($work->id);

            if (!$extendedEntity->save()) {
                throw new ValidationException($extendedEntity);
            }

            $transaction->commit();
        } catch (Throwable $e) {
            $transaction->rollBack();

            throw $e;
        }

        return $work;
    }
}
