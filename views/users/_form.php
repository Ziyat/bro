<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\user\UserHelper;

/* @var $this yii\web\View */
/* @var $model app\forms\user\UserForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
    <div class="box-body">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
        <?php if (!$model->is_admin): ?>
        <?= $form->field($model, 'status')->dropDownList([0 => 'Не активный', 10 => 'Активный']) ?>
        <?php endif; ?>
        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-flat btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
