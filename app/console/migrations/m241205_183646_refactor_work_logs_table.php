<?php

use common\models\Works\WorkLog;
use yii\db\Migration;

class m241205_183646_refactor_work_logs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(WorkLog::tableName(), 'date_processed');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn(WorkLog::tableName(), 'date_processed', $this->dateTime());
    }
}
