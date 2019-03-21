<?php

namespace common\models;

/**
 * This is the model class for table "accounts".
 *
 * @property int $id
 * @property string $balance
 */
class Account extends \yii\db\ActiveRecord
{
    use HasBalance;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accounts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['balance'], 'number'],
            [['name'], 'required'],
            [['name'], 'string'],
            [['balance'], 'default', 'value' => 0]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'balance' => 'Balance',
            'name' => 'Name',
        ];
    }

    /**
     * Move account funds
     * @param $sum
     * @param $direction
     */
    public function moveFunds($sum, $direction) {
        if($direction == Operation::DIRECTION_OUTCOME) {
            $this->reduceBalance($sum);
        } else {
            $this->increaseBalance($sum);
        }
    }

    /**
     * Find account by name
     * @param $name
     * @return Account|null
     */
    public static function findByName($name)
    {
        return static::findOne(['name' => $name]);
    }
}
