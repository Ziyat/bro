<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\entities\dubious\DubiousSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'attribute' => 'name_cor',
        'contentOptions' => ['nowrap' => 'nowrap'],
        'pageSummary' => 'Итого',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'doc_sum',
        'pageSummary' => true,
    ],
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
        'attribute' => 'pop',
        'contentOptions' => ['nowrap' => 'nowrap']
    ],
    [
        'attribute' => 'ans_per',
        'contentOptions' => ['nowrap' => 'nowrap'],
    ],
    'currency',
    'criterion',
    [
        'attribute' => 'date_msg',
        'format' => ['date', 'php:d.m.Y']
    ],
    [
        'attribute' => 'date_doc',
        'format' => ['date', 'php:d.m.Y'],
    ],

    [
        'attribute' => 'created_at',
        'format' => ['date', 'php:d.m.Y']
    ],

    [
        'attribute' => 'created_by',
        'value' => function ($model) {
            return $model->user->name;
        },
        'contentOptions' => ['nowrap' => 'nowrap'],
    ],
];

?>
<div class="box">
    <div class="box-header">
        <?= Html::tag(
            'button',
            Html::tag('i', null, ['class' => 'fa fa-upload'])
            . ' Импорт',
            [
                'class' => 'btn btn-flat btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#importModal'
            ]
        )
        ?>

        <?= Html::tag(
            'button',
            Html::tag('i', null, ['class' => 'fa fa-search'])
            . ' Расширенный поиск',
            [
                'class' => 'btn btn-flat btn-primary',
                'data-toggle' => 'modal',
                'data-target' => '#searchModal'
            ]
        )
        ?>
        <?= ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'filename' => 'BRS_EXPORT_' . date('d-m-Y'),
            'columns' => $gridColumns,
            'fontAwesome' => true,
            'stream' => true, // this will automatically save file to a folder on web server
            'deleteAfterSave' => false, // this will delete the saved web file after it is streamed to browser,
            'target' => '_blank',
            'exportConfig' => [
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_EXCEL => false,
                ExportMenu::FORMAT_CSV => false,
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_EXCEL_X => [
                    'label' => 'Excel 2007+',
                    'icon' => 'file-excel-o',
                    'iconOptions' => ['class' => 'text-success'],
                    'linkOptions' => [],
                    'options' => ['title' => 'Microsoft Excel 2007+ (xlsx)'],
                    'alertMsg' => 'EXCEL 2007+ (xlsx) файл экспорта будет сгенерирован для загрузки.',
                    'mime' => 'application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'extension' => 'xlsx',
                    'writer' => ExportMenu::FORMAT_EXCEL_X
                ],
            ]
        ]); ?>
    </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,

            'tableOptions' => [
                'class' => 'table table-striped table-bordered',
            ],
            'layout'=>"{summary}\n{items}\n <div class='box-footer'>{pager}</div>",
            'columns' => $gridColumns,
            'pjax' => true,
            'showPageSummary' => true,
            'panel' => false
        ]);
        ?>

</div>
    <!-- Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Импорт Excel</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <p><i class="fa fa-warning"></i>
                            Внимание! Прежде чем загружать свой файл, скачайте шаблон Excel <a
                                    href="/upload/template.xlsx">здесь</a>
                        </p>
                    </div>
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'file')
                        ->label('Excel File')
                        ->widget(\kartik\file\FileInput::class) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Расширенный поиск</h4>
                </div>
                <div class="modal-body">
                    <?= $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
        </div>
</div>

<?php

$script = <<<JS
$(document).ready(function() {
    currencyFormatter();
});

$(document).ajaxComplete(function() {
    currencyFormatter();
});

function currencyFormatter(){
    var data = $('td[data-col-seq="2"]');
    var total = $('.kv-page-summary td:eq(2)');
    total.text(addPeriod(total.text()));
    data.each(function( index ) {
        var self = $(this);
        var output = addPeriod(self.text());
        self.text(output);
    });
}

function addPeriod(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
JS;

$this->registerJs($script);
