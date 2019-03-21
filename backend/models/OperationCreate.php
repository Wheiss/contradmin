<?php

namespace backend\models;

/**
 * This is the model class for table "operations".
 *
 * @property int $id
 * @property string $sum
 * @property int $created_at
 * @property string $contragent
 * @property int $account_name
 * @property bool $direction
 * @property string $contragent_balance
 * @property string $account_balance
 */
class OperationCreate extends \common\models\Operation
{
    public $account_name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sum'], 'number'],
            [['sum', 'contragent', 'account_name', 'direction'], 'required'],
            [['created_at'], 'integer'],
            [['direction'], 'boolean'],
            [['contragent', 'account_name'], 'string', 'max' => 255],
            [['contragent'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sum' => 'Sum',
            'contragent' => 'Contragent email',
            'account_name' => 'Account name',
            'direction' => 'Direction',
        ];
    }

}
