<?php

use yii\helpers\Html;
use yii\grid\GridView;
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
    'name_cli',
    'mfo_cor',
    'inn_cor',
    'account_cor',
    'name_cor',
    'doc_sum',
    'pop',
    'ans_per',
    'currency',
    'criterion',
    [
        'attribute' => 'date_msg',
        'value' => function ($model) {
            $date = explode('-',$model->date_msg);
            $arr = $date[2] . '-' . $date[0] . '-' . $date[1];
            return Date('d.m.Y', strtotime($arr));
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
        'filter' => ArrayHelper::map(User::find()->where(['id' => DubiousHelper::getUsersInGroup(Yii::$app->user->identity, new UsersAssignment())])->asArray()->all(), 'id', 'name')
    ],
//    [
//        'attribute' => 'updated_by',
//        'value' => function ($model) {
//            return $model->user->name;
//        },
//        'filter' => ArrayHelper::map(User::find()->where(['id' => DubiousHelper::getUsersInGroup(Yii::$app->user->identity, new UsersAssignment())])->asArray()->all(), 'id', 'name')
//    ],
//    [
//        'label' => 'файл',
//        'value' => function ($model) {
//            $realPath = realpath("upload");
//            for ($i=0; $i <= 5; $i--){
//                if(file_exists($realPath.'/'.($model->created_at + $i).'.xlsx')){
//                    $link = Html::a('<i class="fa fa-download"></i>','/upload/'.$model->created_at.'.xlsx');
//                    break;
//                }else{
//                    $link = '<i class="fa fa-ban"></i>';
//                }
//            }
//
//            return $link;
//        },
//        'format' => 'html'
//    ],
//    ['class' => 'yii\grid\ActionColumn'],
];

?>

<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="box">
    <div class="box-body">
        <?php

        echo ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            exportConfig => [
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_EXCEL => false,
                ExportMenu::FORMAT_CSV => false,
                ExportMenu::FORMAT_HTML => false,
            ]
        ]);

        ?>


        <?php

        echo \kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns
        ]);

        ?>
    </div>
</div>
