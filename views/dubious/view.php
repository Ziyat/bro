<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\dubious\DubiousHelper;
use yii\helpers\ArrayHelper;
use app\entities\user\User;
use app\entities\dubious\Dubious;

/* @var $this yii\web\View */
/* @var $model app\entities\dubious\Dubious */

$this->title = $model->name_cli;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dubious-view">

        <?= Html::a('Редактировать', ["dubious/$model->id/update"], ['class' => 'btn btn-flat btn-primary']) ?>
        <?= Html::a('Удалить', ["dubious/$model->id/delete"], [
            'class' => 'btn btn-flat btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    <div class="btn-group pull-right" role="group" aria-label="...">
        <?php foreach (DubiousHelper::getControlButtons($model->id,$model->created_by) as $button) : ?>
            <?= $button ?>
        <?php endforeach; ?>
    </div>
    <p></p>
    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'id_cli',
                    'mfo_cli',
                    'inn_cli',
                    'account_cli',
                    'name_cli',
                    'mfo_cor',
                    'inn_cor',
                    'account_cor',
                    'name_cor',
                    'date_msg',
                    'date_doc',
                    'doc_sum',
                    'pop',
                    'ans_per',
                    'currency',
                    'criterion',
                    [
                        'attribute' => 'created_by',
                        'value' => function($model){
                            return $model->user->name;
                        },
                        'filter'=> ArrayHelper::map(User::find()->asArray()->all(),'id','name')
                    ],
                    [
                        'attribute' => 'updated_by',
                        'value' => function($model){
                            return $model->user->name;
                        },
                        'filter'=> ArrayHelper::map(User::find()->asArray()->all(),'id','name')
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>


</div>
