<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\forms\dubious\DubiousForm */
/* @var $dubious app\entities\dubious\Dubious */

$this->title = 'Редактирование: '. $model->name_cli;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_cli, 'url' => ['view', 'id' => $dubious->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="dubious-update">
    <?= $this->render('_form', [
        'model' => $model,
        'dubious' => $dubious,
    ]) ?>

</div>
