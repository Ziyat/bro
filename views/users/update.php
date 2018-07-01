<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\forms\user\UserForm */
/* @var $user app\entities\user\User */

$this->title = 'Редактирование: '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="user-update">
    <?= $this->render('_form', [
        'model' => $model,
        'user' => $user,
    ]) ?>

</div>
