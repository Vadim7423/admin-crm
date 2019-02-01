<?php

use yii\db\Migration;

/**
 * Handles the creation of table `positions`.
 */
class m190115_114015_create_positions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('positions', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'created' => $this->datetime()->notNull(),
            'modified' => $this->datetime()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('positions');
    }
}
