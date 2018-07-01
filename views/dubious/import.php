<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $model app\entities\dubious\Dubious */

$this->title = 'Импорт Excel';
$this->params['breadcrumbs'][] = ['label' => 'сомнительные', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-body">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'file')->widget(FileInput::class) ?>

        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-flat btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
