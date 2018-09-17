<?php
/**
 * Created by Madetec-Solution OK.
 * Developer: Mirkhanov Z.S.
 * Date: 19.06.2018
 */

use app\entities\dubious\Dubious;
use app\entities\user\UsersGroup;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'user.name'

];
$provider = new \yii\data\ActiveDataProvider([
    'query' => Dubious::find()
        ->select(['*', 'COUNT(*) AS count'])
        ->groupBy(['criterion', 'updated_by'])
        ->orderBy('updated_by')
        ->with(['user' => function ($q) {
            $q->joinWith(['groups' => function ($j) {
                $j->joinWith(['parent as p']);
            }]);
        }]),
    'pagination' => [
        'pageSize' => 40,
    ],
]);
$groupNames = ArrayHelper::map(UsersGroup::find()->orderBy('name')->asArray()->all(), 'id', 'name');
$gridColumns = [


    [
        'attribute' => 'region',
        'width' => '310px',
        'value' => function ($model, $key, $index, $widget) {
            if(isset($model['user']['groups'][0]['parent']['name'])){
                return $model['user']['groups'][0]['parent']['name'];
            }

            return null;

        },
        'filterType' => GridView::FILTER_SELECT2,

        'filter' => $groupNames,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Any supplier'],
        'group' => true,  // enable grouping,
        'groupedRow' => true,                    // move grouped column to a single grouped row
        'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
        'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class

    ],

    [
        'attribute' => 'Филиал',
        'width' => '250px',
        'value' => function ($model, $key, $index, $widget) {
            if(isset($model['user']['groups'][0]['name'])){
                return $model['user']['groups'][0]['name'];
            }

            return null;
        },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => $groupNames,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Any category'],
        'group' => true,  // enable grouping
        'subGroupOf' => 1, // supplier column index is the parent group
        'pageSummary' => 'Общее количество',
    ],
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'attribute' => 'user',
        'label' => 'Оператор',
        'value' => function($model){
            return $model['user']['name'];
        },
    ],
    [
        'attribute' => 'criterion',
        'label' => 'Критерий',
    ],
    [
        'attribute' => 'count',
        'label' => 'Колличество',
        'pageSummary' => true,
    ],


];
?>


<?= GridView::widget([
    'dataProvider' => $provider,
    'showPageSummary' => true,
    'pjax' => true,
    'striped' => true,
    'hover' => true,
    'panel' => ['type' => 'default', 'heading' => 'Онлайн отчет для ЦБ'],
    'columns' => $gridColumns,
]);

?>

