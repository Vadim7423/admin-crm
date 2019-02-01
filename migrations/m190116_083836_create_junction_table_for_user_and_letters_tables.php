<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_letters`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `letters`
 */
class m190116_083836_create_junction_table_for_user_and_letters_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_letters', [
            'user_id' => $this->integer(),
            'letters_id' => $this->integer(),
            'PRIMARY KEY(user_id, letters_id)',
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-user_letters-user_id',
            'user_letters',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-user_letters-user_id',
            'user_letters',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `letters_id`
        $this->createIndex(
            'idx-user_letters-letters_id',
            'user_letters',
            'letters_id'
        );

        // add foreign key for table `letters`
        $this->addForeignKey(
            'fk-user_letters-letters_id',
            'user_letters',
            'letters_id',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-user_letters-user_id',
            'user_letters'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-user_letters-user_id',
            'user_letters'
        );

        // drops foreign key for table `letters`
        $this->dropForeignKey(
            'fk-user_letters-letters_id',
            'user_letters'
        );

        // drops index for column `letters_id`
        $this->dropIndex(
            'idx-user_letters-letters_id',
            'user_letters'
        );

        $this->dropTable('user_letters');
    }
}
