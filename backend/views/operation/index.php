<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \kartik\field\FieldRange;
use common\models\Operation;

/* @var $this yii\web\View */
/* @var $searchModel \common\models\OperationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Operations';
?>
<div class="operation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Operation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'sum',
                'filter' => FieldRange::widget([
                    'labelOptions' => ['class' => 'hidden'],
                    'model' => $searchModel,
                    'attribute1' => 'sum_from',
                    'attribute2' => 'sum_to',
                ])
            ],
            [
                'attribute' => 'created_at',
                'filter' => FieldRange::widget([
                    'type' => FieldRange::INPUT_DATETIME,
                    'labelOptions' => ['class' => 'hidden'],
                    'model' => $searchModel,
                    'attribute1' => 'created_at_from',
                    'attribute2' => 'created_at_to',
                ])
            ],
            'contragent',
            [
                'attribute' => 'account',
                'value' => 'account.name',
            ],
            [
                'attribute' => 'direction',
                'content' => function ($data) {
                    return $data->getDirectionStr();
                },
                'filter' => Operation::DIRECTION_STRS,
            ]
        ],
    ]); ?>
</div>
