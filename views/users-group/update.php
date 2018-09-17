<?php

/* @var $this yii\web\View */
/* @var $model app\entities\user\UsersGroup */

$this->title = 'Редактирование Группы';
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
