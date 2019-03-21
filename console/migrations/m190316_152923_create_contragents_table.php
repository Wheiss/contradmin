<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contragents}}`.
 */
class m190316_152923_create_contragents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contragents}}', [
            'email' => $this->string(),
            'balance' => $this->decimal(14, 4)
                ->notNull()
                ->defaultValue(0),
        ]);
        $this->addPrimaryKey('email', '{{%contragents}}', 'email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contragents}}');
    }
}
