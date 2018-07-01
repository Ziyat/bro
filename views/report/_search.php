<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name_client') ?>

    <?= $form->field($model, 'name_correspondent') ?>

    <?= $form->field($model, 'account_client') ?>

    <?= $form->field($model, 'account_correspondent') ?>

    <?php // echo $form->field($model, 'currency_code') ?>

    <?php // echo $form->field($model, 'criteria_code') ?>

    <?php // echo $form->field($model, 'payment_details') ?>

    <?php // echo $form->field($model, 'informer') ?>

    <?php // echo $form->field($model, 'mfo') ?>

    <?php // echo $form->field($model, 'date_operation') ?>

    <?php // echo $form->field($model, 'date_message') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
