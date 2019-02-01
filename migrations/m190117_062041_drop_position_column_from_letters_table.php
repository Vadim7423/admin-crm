<?php

use yii\db\Migration;

/**
 * Handles dropping position from table `letters`.
 */
class m190117_062041_drop_position_column_from_letters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
   public function up()
    {
        $this->dropColumn('letters', 'contragent_str');
    }

    public function down()
    {
        $this->addColumn('letters', 'contragent_str', $this->string()->notNull());
    }
}
