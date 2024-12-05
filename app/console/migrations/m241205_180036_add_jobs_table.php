<?php

use yii\db\Migration;

class m241205_180036_add_jobs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('jobs', [
            'id' => $this->primaryKey(),
            'work_id' => $this->integer()->notNull()->unsigned(),
            'params' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('jobs');
    }
}
