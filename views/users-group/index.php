<?php

use app\entities\user\UsersGroup;
use app\helpers\user\UserHelper;
use yii\grid\GridView;
use yii\helpers\Html;

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
                    [
                        'attribute' => 'name',
                        'value' => function (UsersGroup $model) {
                            return $model->parent ? '–– ' . $model->name : $model->name;
                        }
                    ],
                    [
                        'attribute' => 'parent_id',
                        'label' => 'Родитель',
                        'value' => function (UsersGroup $model) {
                            return $model->parent ?  $model->parent->name : null;
                        }
                    ],
                    [
                        'attribute' => 'Пользователи',
                        'value' => function (UsersGroup $model) {
                            return UserHelper::getLinkAssignments($model->users, 'users');
                        },
                        'format' => 'raw'
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
