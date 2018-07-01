<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\helpers\user\UserHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\entities\user\UsersGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Группы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-group-index">
    <div class="box">
        <div class="box-header">
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-plus']) . ' Добавить', ['create'], ['class' => 'btn btn-flat btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    [
                        'attribute' => 'Пользователи',
                        'value' => function ($model) {
                            return UserHelper::getLinkAssignments($model->assignments, 'users');
                        },
                        'format' => 'raw'
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
