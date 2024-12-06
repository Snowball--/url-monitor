<?php

use common\models\Works\WorkLog;
use yii\db\Migration;

class m241206_123502_add_error_data_to_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(WorkLog::tableName(), 'error_data', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(WorkLog::tableName(), 'error_data');
    }
}
