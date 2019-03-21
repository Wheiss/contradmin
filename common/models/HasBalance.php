<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 3/20/19
 * Time: 8:33 PM
 */

namespace common\models;

/**
 * Trait HasBalance
 * @property $balance
 * @package common\models
 */
trait HasBalance
{
    /**
     * Get balance
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * Reduce balance
     * @param $sum
     * @return Contragent
     */
    public function reduceBalance($sum): self
    {
        $this->balance -= $sum;
        $this->save();
        return $this;
    }

    /**
     * Increase balance
     * @param $sum
     * @return Contragent
     */
    public function increaseBalance($sum): self
    {
        $this->balance += $sum;
        $this->save();
        return $this;
    }
}