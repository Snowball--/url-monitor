<?php

use common\models\WorkLogs\WorkLog;
use yii\db\Migration;

class m241204_120548_change_work_logs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn(WorkLog::tableName(), 'date_time', 'date_created');
        $this->addColumn(WorkLog::tableName(), 'date_processed', $this->dateTime()->defaultValue(null)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(WorkLog::tableName(), 'date_processed');
        $this->renameColumn(WorkLog::tableName(), 'date_created', 'date_time');
    }
}
