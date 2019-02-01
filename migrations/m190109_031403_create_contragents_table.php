<?php

use yii\db\Migration;

/**
 * Handles the creation of table `contragents`.
 */
class m190109_031403_create_contragents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%contragents}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'created' => $this->datetime()->notNull(),
            'modified' => $this->datetime()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('contragents');
    }
}
