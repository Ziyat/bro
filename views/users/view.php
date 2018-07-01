<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\user\UserHelper;

/* @var $this yii\web\View */
/* @var $model app\entities\user\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <p>
        <?= Html::a('Редактировать', ["users/$model->id/update"], ['class' => 'btn btn-flat btn-primary']) ?>
        <?= Html::a('Удалить', ["users/$model->id/delete"], [
            'class' => 'btn btn-flat btn-danger pull-right',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php if (!$model->is_admin): ?>
            <?php if ($model->isActive()): ?>
                <?= Html::a('Деактивировать', ['deactivate', 'id' => $model->id], ['class' => 'btn btn-flat btn-default pull-right', 'data-method' => 'post']) ?>
            <?php else: ?>
                <?= Html::a('Активировать', ['activate', 'id' => $model->id], ['class' => 'btn btn-flat btn-success', 'data-method' => 'post']) ?>
            <?php endif; ?>
        <?php endif; ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'username',
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return UserHelper::statusLabel($model->status);
                        },
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'Группы',
                        'value' => function ($model) {
                            return UserHelper::getLinkAssignments($model->assignments,'users-group');
                        },
                        'format' => 'raw'
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>


</div>
