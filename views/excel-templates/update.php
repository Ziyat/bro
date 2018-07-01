<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\entities\ExcelTemplates */

$this->title = 'Update Excel Templates: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Excel Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="excel-templates-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
