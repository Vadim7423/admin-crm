<?php

use yii\db\Migration;

/**
 * Class m190115_113855_add_new_fields_to_user
 */
class m190115_113855_add_new_fields_to_profile extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('profile', 'sername', $this->string()->notNull());
        $this->addColumn('profile', 'parent_name', $this->string()->notNull());
        $this->addColumn('profile', 'position_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('{{%profile}}', 'position_id');
        $this->dropColumn('{{%profile}}', 'parent_name');
        $this->dropColumn('{{%profile}}', 'sername');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190115_113855_add_new_fields_to_user cannot be reverted.\n";

        return false;
    }
    */
}
