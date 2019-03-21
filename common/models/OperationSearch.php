<?php

namespace common\models;

use yii\data\ActiveDataProvider;
use Yii;
use yii\db\ActiveQuery;

/**
 * OperationSearch represents the model behind the search form of `common\models\Operation`.
 */
class OperationSearch extends Operation
{
    public $sum_from = null;
    public $sum_to = null;
    public $created_at_from = null;
    public $created_at_to = null;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // date format: 2019-03-12 00:00
            [['created_at_from', 'created_at_to'], 'datetime', 'format' => 'php:Y-m-d H:i'],
            [['contragent'], 'string'],
            [['sum_from', 'sum_to'], 'number'],
            [['direction', 'account'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Operation::find();
        $query->joinWith(['account']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['account'] = [
            'asc' => ['accounts.name' => SORT_ASC],
            'desc' => ['accounts.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['direction' => $this->direction,]);
        $this->addContragentFilter($query);
        $query->andFilterWhere(['like', 'accounts.name', $this->account]);
        $query->andFilterWhere(['between', 'sum', $this->sum_from, $this->sum_to]);

        $formatter = Yii::$app->formatter;
        $formatter->nullDisplay = null;
        $query->andFilterWhere(['between',
            'created_at',
            $this->created_at_from ? $formatter->asTimestamp($this->created_at_from) : null,
            $this->created_at_to ? $formatter->asTimestamp($this->created_at_to) : null,
        ]);

        return $dataProvider;
    }

    /**
     * Adds Contragent filter to query
     * @param $query
     * @return $this
     */
    protected function addContragentFilter(ActiveQuery $query)
    {
        $query->andFilterWhere(['like', 'contragent', $this->contragent]);
        return $this;
    }

    /**
     * Sets the account search field
     * @param $value
     */
    public function setAccount($value)
    {
        $this->account = $value;
    }
}
