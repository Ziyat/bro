<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\user\UserHelper;

/* @var $this yii\web\View */
/* @var $model app\entities\user\UsersGroup */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-group-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-flat btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-flat btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'Пользователи',
                'value' => function ($model) {
                    return UserHelper::getLinkAssignments($model->assignments,'users');
                },
                'format' => 'raw'
            ]
        ],
    ]) ?>

</div>
