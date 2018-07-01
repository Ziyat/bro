<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\entities\dubious\Dubious */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
    <div class="box-body">

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'id_cli')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'mfo_cli')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'inn_cli')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'account_cli')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'name_cli')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'mfo_cor')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'inn_cor')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'account_cor')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'name_cor')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'date_msg')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'date_doc')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'doc_sum')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'pop')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'ans_per')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'criterion')->textInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-flat btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
