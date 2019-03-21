<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * OperationSearch represents the model behind the search form of `common\models\Operation`.
 */
class OperationSearch extends \common\models\OperationSearch
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // date format: 2019-03-12 00:00
            [['created_at_from', 'created_at_to'], 'datetime', 'format' => 'php:Y-m-d H:i'],
            [['sum_from', 'sum_to'], 'number'],
            [['direction', 'account'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function addContragentFilter(ActiveQuery $query)
    {
        $query->andFilterWhere(['contragent' => $this->contragent]);
        return $this;
    }


}
