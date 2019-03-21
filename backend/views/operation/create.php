<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Operation */

$this->title = 'Create Operation';
?>
<div class="operation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
