<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%accounts}}`.
 */
class m190316_152844_create_accounts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%accounts}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
                ->notNull()
                ->unique(),
            'balance' => $this->decimal(14,4)
                ->notNull()
                ->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%accounts}}');
    }
}
