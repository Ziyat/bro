<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\entities\dubious\Client;
use app\entities\dubious\Correspondent;
use app\entities\dubious\Dubious;


/* @var $this yii\web\View */
/* @var $model app\models\ReportSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<!-- /.box-header -->
<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>

<div class="box box-primary">
    <div class="box-header">
        <h4>Расширенный поиск</h4>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="col-md-2">
            <h5><b>Дата</b></h5>
        </div>
        <div class="col-md-5 form-group">
            <?= \kartik\date\DatePicker::widget([
                'name' => 'DubiousSearch[date_msg]',
                'options' => ['placeholder' => 'Выберите дату сообщения'],
                'pluginOptions' => [
                    'format' => 'mm-dd-yy',
                    'todayHighlight' => true
                ]
            ]) ?>
        </div>
        <div class="col-md-5 form-group">
            <?= \kartik\date\DatePicker::widget([
                'name' => 'DubiousSearch[date_doc]',
                'options' => ['placeholder' => 'Выберите дату проводки'],
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'todayHighlight' => true
                ]
            ]) ?>
        </div>
        <hr>
        <div class="clearfix"></div>
        <div class="col-md-2">
            <h5><b>Клиент</b></h5>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'mfo_cli')
                ->label(false)
                ->dropDownList(Client::mfoList(new Dubious()), ['prompt' => 'Выберите МФО']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'id_cli')
                ->label(false)
                ->textInput(['maxlength' => true,'placeholder' => 'ID']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'inn_cli')
                ->label(false)
                ->textInput(['maxlength' => true,'placeholder' => 'ИНН']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'account_cli')
                ->label(false)
                ->textInput(['maxlength' => true,'placeholder' => 'Счет']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'name_cli')
                ->label(false)
                ->textInput(['maxlength' => true,'placeholder' => 'Наименование']) ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-2">
            <h5><b>Корреспондент</b></h5>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'mfo_cor')
                ->label(false)
                ->dropDownList(Correspondent::mfoList(new Dubious()), ['prompt' => 'Выберите МФО']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'inn_cor')
                ->label(false)
                ->textInput(['maxlength' => true,'placeholder' => 'ИНН']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'account_cor')
                ->label(false)
                ->textInput(['maxlength' => true,'placeholder' => 'Счет']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'name_cor')
                ->label(false)
                ->textInput(['maxlength' => true,'placeholder' => 'Наименование']) ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-2">
            <h5><b>Доп. параметры</b></h5>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'doc_sum')->textInput(['maxlength' => true,'placeholder' => 'Сумма документа'])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'pop')->textInput(['maxlength' => true,'placeholder' => 'Назначение платежа'])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'ans_per')->textInput(['maxlength' => true,'placeholder' => 'Ответ исполнитель'])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'currency')->textInput(['maxlength' => true,'placeholder' => 'Валюта'])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'criterion')->textInput(['maxlength' => true,'placeholder' => 'Критерий'])->label(false) ?>
        </div>
    </div>
    <div class="box-footer clearfix">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-block btn-primary btn-flat']) ?>
            <?= Html::a('Очистить','/dubious', ['class' => 'btn btn-block btn-default btn-flat']) ?>


    </div>
</div>


<?php ActiveForm::end(); ?>
