<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Import';
?>
<div class="import-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php if (!empty($errors)): ?>
        <div class="has-error">
            <?php foreach ($errors as $error): ?>
                <div class="help-block"><?= $error ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?= $form->field($model, 'file')->fileInput() ?>

    <button>Import operations</button>

    <?php ActiveForm::end() ?>
</div>