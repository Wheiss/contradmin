<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "operations".
 *
 * @property int $id
 * @property string $sum
 * @property int $created_at
 * @property int $contragent
 * @property int $account_id
 * @property bool $direction
 */
class Operation extends \yii\db\ActiveRecord
{
    const DIRECTION_INCOME = true;
    const DIRECTION_OUTCOME = false;
    const DIRECTION_INCOME_STR = 'income';
    const DIRECTION_OUTCOME_STR = 'outcome';
    const DIRECTION_STRS = [
        self::DIRECTION_INCOME => self::DIRECTION_INCOME_STR,
        self::DIRECTION_OUTCOME => self::DIRECTION_OUTCOME_STR,
    ];
    const DIRECTION_STRS_FOR_CONTRAGENT = [
        self::DIRECTION_INCOME => self::DIRECTION_OUTCOME_STR,
        self::DIRECTION_OUTCOME => self::DIRECTION_INCOME_STR,
    ];

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
            [['contragent', 'account_id', 'direction', 'contragent_balance', 'account_balance', 'created_at'], 'required'],
            [['account_id'], 'integer'],
            [['contragent'], 'string'],
            [['direction'], 'boolean'],
            [['contragent_balance', 'account_balance'], 'number'],
            [['created_at', 'sum', 'contragent', 'account_id', 'direction'], 'unique', 'targetAttribute' => ['created_at', 'sum', 'contragent', 'account_id', 'direction']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    'createdAtAttribute' => 'created_at',
                    'updatedAtAttribute' => false,

                ],
            ],
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
            'created_at' => 'Created At',
            'contragent' => 'Contragent',
            'account_id' => 'Account ID',
            'direction' => 'Direction',
        ];
    }

    /**
     * Get available directions for accounts
     * @return string
     */
    public function getDirectionStr(): string
    {
        return self::DIRECTION_STRS[$this->direction];
    }

    /**
     * Get available operation directions for contragent
     * @return string
     */
    public function getContragentDirectionStr(): string
    {
        return self::DIRECTION_STRS_FOR_CONTRAGENT[$this->direction];
    }

    /**
     * Get account
     * @return \yii\db\ActiveQuery
     */
    public function getAccount() : ?ActiveQuery
    {
        return $this->hasOne(Account::class, ['id' => 'account_id']);
    }

    /**
     * Get contragent
     * @return \yii\db\ActiveQuery
     */
    public function getContragent() : ?ActiveQuery
    {
        return $this->hasOne(Contragent::class, ['email' => 'contragent']);
    }
}
