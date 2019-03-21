<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/17/19
 * Time: 11:06 PM
 */

namespace backend\models;


use common\models\Contragent;
use yii\data\ActiveDataProvider;

class ContragentSearch extends Contragent
{
    public $balance_from = null;
    public $balance_to = null;

    //important
    function rules()
    {
        return [
            [['email'], 'string'],
            [['balance_from', 'balance_to'], 'number'],
            [['owner.email'], 'safe']
        ];
    }

    /**
     * Search for contragents
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = parent::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['between', 'balance', $this->balance_from, $this->balance_to]);

        return $dataProvider;
    }
}