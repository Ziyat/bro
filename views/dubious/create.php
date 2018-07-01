<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\entities\dubious\Dubious */

$this->title = 'Создать сомнителя';
$this->params['breadcrumbs'][] = ['label' => 'сомнительные', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dubious-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
