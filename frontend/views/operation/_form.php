<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Operation;

/* @var $this yii\web\View */
/* @var $model common\models\Operation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sum')->textInput() ?>

    <?= $form->field($model, 'account_name')->textInput() ?>

    <?= $form->field($model, 'direction')->dropDownList(Operation::DIRECTION_STRS_FOR_CONTRAGENT) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
