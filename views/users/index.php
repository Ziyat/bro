<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\helpers\user\UserHelper;
use app\entities\user\User;

/* @var $this yii\web\View */
/* @var $searchModel app\entities\user\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="box">
        <div class="box-header">
            <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-flat btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'name',
                        'value' => function($model){
                           return Html::a($model->name,Url::to(['users/view','id' =>$model->id]));
                        },
                        'format' => 'html'
                    ],
                    'username',
                    [
                        'attribute' => 'status',
                        'value' => function($model){
                                return UserHelper::statusLabel($model->status);
                        },
                        'filter' => UserHelper::statusList(),
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'Группы',
                        'value' => function (User $model) {
                            return UserHelper::getLinkAssignments($model->groups,'users-group');
                        },
                        'format' => 'raw'
                    ],

                    'created_at:datetime',
                    'updated_at:datetime',

                    [
                            'attribute' => 'Войти в систему как этот пользователь',
                            'value' => function ($model){
                                return Html::a(
                                        Html::tag('i',
                                        '',
                                        ['class' => 'fa fa-sign-in fa-2x']),
                                        ['imitation','user_id' => $model->id]);
                            },
                            'format' => 'raw'
                    ]
                ],
            ]); ?>
        </div>
    </div>

</div>
