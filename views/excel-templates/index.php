<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\entities\excel\ExcelTemplatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Excel шаблоны';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-header">
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-flat btn-success']) ?>
    </div>
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>


