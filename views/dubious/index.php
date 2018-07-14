<?php

use yii\helpers\Html;
use \kartik\grid\GridView;
use yii\helpers\Url;
use app\helpers\dubious\DubiousHelper;
use yii\helpers\ArrayHelper;
use app\entities\user\User;
use app\entities\user\UsersAssignment;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\entities\dubious\DubiousSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    'id_cli',
    'mfo_cli',
    'inn_cli',
    'account_cli',
    [
        'attribute' => 'name_cli',
        'contentOptions' => ['nowrap' => 'nowrap']
    ],
    'mfo_cor',
    'inn_cor',
    'account_cor',
    [
            'attribute' => 'name_cor',
            'contentOptions' => ['nowrap' => 'nowrap']
    ],
    'doc_sum',
    [
        'attribute' => 'pop',
        'contentOptions' => ['nowrap' => 'nowrap']
    ],
    'ans_per',
    'currency',
    'criterion',
    [
        'attribute' => 'date_msg',
        'value' => function ($model) {
            return Date('d.m.Y', DubiousHelper::dateToTime('m.d.y',$model->date_msg));

        },
        'filter' => \kartik\daterange\DateRangePicker::widget([
            'model' => $searchModel,
            'attribute' => 'dateMsgTimeRange',
            'convertFormat' => true,
            'pluginOptions' => [
                'locale' => [
                    'format' => 'Y-m-d',
                ]
            ]
        ])
    ],
    'date_doc',

    [
        'attribute' => 'created_at',

        'format' => ['date','php:d.m.Y'],
        'filter' => \kartik\daterange\DateRangePicker::widget([
            'model' => $searchModel,
            'attribute' => 'createTimeRange',
            'convertFormat' => true,
            'pluginOptions' => [
                'locale' => [
                    'format' => 'Y-m-d',
                ]
            ]
        ])
    ],
    [
        'attribute' => 'created_by',
        'value' => function ($model) {
            return $model->user->name;
        },
        'contentOptions' => ['nowrap' => 'nowrap'],
        'filter' => ArrayHelper::map(User::find()->where(['id' => DubiousHelper::getUsersInGroup(Yii::$app->user->identity, new UsersAssignment())])->asArray()->all(), 'id', 'name')
    ]
];

?>

<?php  $this->render('_search', ['model' => $searchModel]); ?>

    <?= ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'exportConfig' => [
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_EXCEL => false,
            ExportMenu::FORMAT_CSV => false,
            ExportMenu::FORMAT_HTML => false,
        ]
    ]);?>
<hr>
<div class="box">
    <div class="box-body" style="overflow: scroll;">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered',
            ],
            'rowOptions'=>function ($model, $key, $index, $grid){
                $class='text-center';
                return [
                    'key'=>$key,
                    'index'=>$index,
                    'class'=>$class
                ];
            },
            'columns' => $gridColumns
        ]);

        ?>
    </div>
</div>