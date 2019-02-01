<?php

use yii\db\Migration;

/**
 * Handles the creation of table `letters`.
 */
class m181227_035223_create_letters_table extends Migration
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
        
        $this->createTable('letters', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'number' => $this->string()->notNull(),
            'date' => $this->datetime()->notNull(),
            'user_id' => $this->integer(5),
            'contragent_str' => $this->string()->notNull(),
            'contragent_id' => $this->integer(5),
            'status_id' => $this->smallInteger()->notNull(),
            'level' => $this->smallInteger()->notNull()->defaultValue(0),
            'direction' => $this->smallInteger()->notNull()->defaultValue(1),
            'created' => $this->datetime()->notNull(),
            'modified' => $this->datetime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('letters');
    }
}
