<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operations}}`.
 */
class m190316_153001_create_operations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%operations}}', [
            'id' => $this->primaryKey(),
            'sum' => $this->decimal(14, 4),
            'created_at' => $this->integer()->notNull(),
            'contragent' => $this->string()->notNull(),
            'account_id' => $this->integer()->notNull(),
            'direction' => $this->boolean()->notNull(),
            'contragent_balance' => $this->decimal(14, 4)->notNull(),
            'account_balance' => $this->decimal(14, 4)->notNull(),
        ]);

        $this->createIndex(
            'idx_unique_created_at_sum_contragent_account_direction',
            'operations',
            ['created_at', 'sum', 'contragent', 'account_id', 'direction'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%operations}}');
    }
}
