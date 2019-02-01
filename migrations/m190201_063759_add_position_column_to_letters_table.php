<?php

use yii\db\Migration;

/**
 * Handles adding position to table `letters`.
 */
class m190201_063759_add_position_column_to_letters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('letters', 'registr', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%letters}}', 'registr');
    }
}
