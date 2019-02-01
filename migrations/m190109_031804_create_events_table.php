<?php

use yii\db\Migration;

/**
 * Handles the creation of table `events`.
 */
class m190109_031804_create_events_table extends Migration
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
        
        $this->createTable('{{%events}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'letter_id' => $this->integer(5)->notNull(),
            'user_id' => $this->integer(5)->notNull(),
            'created' => $this->datetime()->notNull(),
            'modified' => $this->datetime()->notNull(),
        ], $tableOptions);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-events-user_id',
            'events',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-events-user_id',
            'events',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
        
        // creates index for column `letters`
        $this->createIndex(
            'idx-events-letter_id',
            'events',
            'letter_id'
        );

        // add foreign key for table `properties`
        $this->addForeignKey(
            'fk-events-letter_id',
            'events',
            'letter_id',
            'letters',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         // drops foreign key for table `letters`
        $this->dropForeignKey(
            'fk-events-letter_id',
            'events'
        );

        // drops index for column `letter_id`
        $this->dropIndex(
            'idx-events-letter_id',
            'events'
        );
        
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-events-user_id',
            'events'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-events-user_id',
            'events'
        );
        
        $this->dropTable('events');
    }
}
