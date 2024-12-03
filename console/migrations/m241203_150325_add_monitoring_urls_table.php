<?php

use yii\db\Migration;

class m241203_150325_add_monitoring_urls_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('works', [
            'id' => $this->primaryKey(),
            'type' => $this->string()->notNull(),
            'frequency' => $this->integer()->unsigned(),
            'on_error_repeat_count' => $this->integer()->defaultValue(0),
            'on_error_repeat_delay' => $this->integer()->defaultValue(1)->unsigned(),
            'date_created' => $this->dateTime(),
            'is_active' => $this->boolean()->defaultValue(true)
        ]);

        $this->createTable('monitored_urls', [
            'id' => $this->primaryKey(),
            'url' => $this->string(255)
        ]);

        $this->createTable('work_logs', [
            'id' => $this->primaryKey(),
            'work_id' => $this->integer()->unsigned(),
            'date_time' => $this->dateTime(),
            'state' => $this->string()->defaultValue('NEW'),
            'attempt_number' => $this->integer()->defaultValue(1)
        ]);

        $this->createTable('monitored_url_log_details', [
            'id' => $this->primaryKey(),
            'response_code' => $this->integer()->notNull(),
            'response_body' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('works');
        $this->dropTable('monitored_urls');
        $this->dropTable('work_logs');
        $this->dropTable('monitored_url_log_details');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241203_150325_add_monitoring_urls_table cannot be reverted.\n";

        return false;
    }
    */
}
