<?php

use yii\db\Migration;

class m241203_150325_add_monitoring_urls_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241203_150325_add_monitoring_urls_table cannot be reverted.\n";

        return false;
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
