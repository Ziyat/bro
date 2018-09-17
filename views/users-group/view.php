<?php

use app\helpers\user\UserHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 *
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-flat btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-flat btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'name',
                        [
                            'attribute' => 'Пользователи',
                            'value' => UserHelper::getLinkAssignments($model->users, 'users'),
                            'format' => 'raw'
                        ]
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>