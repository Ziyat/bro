<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Report */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'file')->widget(kartik\file\FileInput::class) ?>

    <div class="form-group">
        <?= Html::submitButton('Импортировать', ['class' => 'btn btn-flat btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
