<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\field\FieldRange;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ContragentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contragents';
?>
<div class="operation-index">


    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'email',
            [
                'attribute' => 'balance',
                'filter' => FieldRange::widget([
                    'labelOptions' => ['class' => 'hidden'],
                    'model' => $searchModel,
                    'attribute1' => 'balance_from',
                    'attribute2' => 'balance_to',
                ])
            ]
        ],
    ]); ?>
</div>
