<?php

use yii\db\Migration;

class m210107_161801_create_tables extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        $this->createTable('managers', [
            'id' => $this->primaryKey(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'name' => $this->string()->notNull(),
            'is_works' => $this->boolean()->notNull(),
        ], $tableOptions);

        $this->createTable('requests', [
            'id' => $this->primaryKey(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'email' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'text' => $this->text(),
            'manager_id' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('managers');
        $this->dropTable('requests');
    }
}
