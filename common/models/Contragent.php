<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "contragents".
 *
 * @property float $balance
 * @property string $email
 */
class Contragent extends ActiveRecord
{
    use HasBalance;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%contragents}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'string'],
            [['email'], 'unique'],
            [['balance'], 'number'],
            [['balance'], 'default', 'value' => 0]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => 'User email',
            'balance' => 'Balance',
        ];
    }

    /**
     * Get relation with User model
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['email' => 'email']);
    }

    /**
     * Get user email
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Move contragent funds
     * @param $sum
     * @param $direction
     */
    public function moveFunds($sum, $direction) {
        if($direction == Operation::DIRECTION_INCOME) {
            $this->reduceBalance($sum);
        } else {
            $this->increaseBalance($sum);
        }
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }
}
