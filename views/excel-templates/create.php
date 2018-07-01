<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\entities\ExcelTemplates */

$this->title = 'Create Excel Templates';
$this->params['breadcrumbs'][] = ['label' => 'Excel Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="excel-templates-create">

   <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
