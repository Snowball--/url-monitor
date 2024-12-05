<?php
declare(strict_types=1);

namespace common\models\Works\ActiveQuery;

use common\Enums\WorkActivity;
use common\models\Works\Work;
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

    public function byId(int $id): ?Work
    {
        /* @var Work $work */
        $work = $this->where(['id' => $id])->one();
        return $work;
    }
}