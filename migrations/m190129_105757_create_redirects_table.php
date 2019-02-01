<?php

use yii\db\Migration;

/**
 * Handles the creation of table `redirects`.
 */
class m190129_105757_create_redirects_table extends Migration
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
        
        $this->createTable('{{%redirects}}', [
            'id' => $this->primaryKey(),
            'letter_id' => $this->integer(5)->notNull(),
            'user_id' => $this->integer(5)->notNull(),
            'parent_id' => $this->integer(5)->notNull(),
            'created' => $this->datetime()->notNull(),
            'modified' => $this->datetime()->notNull(),
        ], $tableOptions);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-redirects-user_id',
            'redirects',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-redirects-user_id',
            'redirects',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
        
        // creates index for column `letters`
        $this->createIndex(
            'idx-redirects-letter_id',
            'redirects',
            'letter_id'
        );

        // add foreign key for table `properties`
        $this->addForeignKey(
            'fk-redirects-letter_id',
            'redirects',
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
            'fk-redirects-letter_id',
            'redirects'
        );

        // drops index for column `letter_id`
        $this->dropIndex(
            'idx-redirects-letter_id',
            'redirects'
        );
        
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-redirects-user_id',
            'redirects'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-redirects-user_id',
            'redirects'
        );
        
        $this->dropTable('redirects');
    }
}
