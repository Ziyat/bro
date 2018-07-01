<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\entities\user\UsersGroup */

$this->title = 'Добавить группу';
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
