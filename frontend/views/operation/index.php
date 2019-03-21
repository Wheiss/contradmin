<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \kartik\field\FieldRange;
use common\models\Operation;

/* @var $this yii\web\View */
/* @var $operationsSearch \frontend\models\OperationSearch */
/* @var $operationsProvider yii\data\ActiveDataProvider */
/* @var $contragent \common\models\Contragent */
?>

<div class="row">
    <div class="col-sm-6">
        <h1>contragent/index</h1>
    </div>
    <div class="col-sm-6">
        <h1 class="pull-right">Balance: <?= $contragent->getBalance() ?></h1>
    </div>
</div>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Create Operation', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $operationsProvider,
    'filterModel' => $operationsSearch,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'sum',
            'filter' => FieldRange::widget([
                'labelOptions' => ['class' => 'hidden'],
                'model' => $operationsSearch,
                'attribute1' => 'sum_from',
                'attribute2' => 'sum_to',
            ])
        ],
        [
            'attribute' => 'created_at',
            'filter' => FieldRange::widget([
                'type' => FieldRange::INPUT_DATETIME,
                'labelOptions' => ['class' => 'hidden'],
                'model' => $operationsSearch,
                'attribute1' => 'created_at_from',
                'attribute2' => 'created_at_to',
            ])
        ],
        [
            'attribute' => 'account',
            'value' => 'account.name',
        ],
        [
            'attribute' => 'direction',
            'content' => function ($data) {
                return $data->getContragentDirectionStr();
            },
            'filter' => Operation::DIRECTION_STRS,
        ],
        'contragent_balance'
    ],
]); ?>
