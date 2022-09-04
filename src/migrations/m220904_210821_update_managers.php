<?php

use yii\db\Migration;

/**
 * Class m220904_210821_update_managers
 */
class m220904_210821_update_managers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('managers', 'counter', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('managers', 'counter');
    }
}
