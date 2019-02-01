<?php

use yii\db\Migration;

/**
 * Handles the creation of table `contragents_letters`.
 * Has foreign keys to the tables:
 *
 * - `contragents`
 * - `letters`
 */
class m190117_080218_create_junction_table_for_contragents_and_letters_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('contragents_letters', [
            'contragents_id' => $this->integer(),
            'letters_id' => $this->integer(),
            'PRIMARY KEY(contragents_id, letters_id)',
        ]);

        // creates index for column `contragents_id`
        $this->createIndex(
            'idx-contragents_letters-contragents_id',
            'contragents_letters',
            'contragents_id'
        );

        // add foreign key for table `contragents`
        $this->addForeignKey(
            'fk-contragents_letters-contragents_id',
            'contragents_letters',
            'contragents_id',
            'contragents',
            'id',
            'CASCADE'
        );

        // creates index for column `letters_id`
        $this->createIndex(
            'idx-contragents_letters-letters_id',
            'contragents_letters',
            'letters_id'
        );

        // add foreign key for table `letters`
        $this->addForeignKey(
            'fk-contragents_letters-letters_id',
            'contragents_letters',
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
        // drops foreign key for table `contragents`
        $this->dropForeignKey(
            'fk-contragents_letters-contragents_id',
            'contragents_letters'
        );

        // drops index for column `contragents_id`
        $this->dropIndex(
            'idx-contragents_letters-contragents_id',
            'contragents_letters'
        );

        // drops foreign key for table `letters`
        $this->dropForeignKey(
            'fk-contragents_letters-letters_id',
            'contragents_letters'
        );

        // drops index for column `letters_id`
        $this->dropIndex(
            'idx-contragents_letters-letters_id',
            'contragents_letters'
        );

        $this->dropTable('contragents_letters');
    }
}
