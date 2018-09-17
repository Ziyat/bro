<?php

use app\entities\dubious\Client;
use app\entities\dubious\Correspondent;
use app\entities\dubious\Dubious;
use app\entities\dubious\Params;
use kartik\daterange\DateRangePicker;
use kartik\number\NumberControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\entities\user\User;
use app\helpers\dubious\DubiousHelper;


/* @var $this yii\web\View */
/* @var $model app\models\ReportSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<!-- /.box-header -->
<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>
<div class="row">
    <div class="col-md-2">
        <h5><b>Дата</b></h5>
    </div>
    <div class="col-md-5 form-group">
        <?= DateRangePicker::widget([
            'model' => $model,
            'attribute' => 'dateDocRange',
            'convertFormat' => true,
            'startAttribute' => 'dateDocStart',
            'endAttribute' => 'dateDocEnd',
            'options' => [
                'readonly' => 'readonly',
                'placeholder' => 'Дата проводки',
                'class' => 'form-control',
            ],
            'pluginOptions' => [
                'locale' => [
                    'format' => 'd-m-Y'
                ]
            ]
        ]); ?>
    </div>
    <div class="col-md-5 form-group">
        <?= DateRangePicker::widget([
            'model' => $model,
            'attribute' => 'dateMsgRange',
            'convertFormat' => true,
            'startAttribute' => 'dateMsgStart',
            'endAttribute' => 'dateMsgEnd',
            'options' => [
                'readonly' => 'readonly',
                'placeholder' => 'Дата сообщения',
                'class' => 'form-control',
            ],
            'pluginOptions' => [
                'locale' => [
                    'format' => 'd-m-Y'
                ]
            ]
        ]); ?>
    </div>
    <hr>
    <div class="clearfix"></div>
    <div class="col-md-2">
        <h5><b>Клиент</b></h5>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'mfo_cli')
            ->label(false)
            ->dropDownList(Client::mfoList(new Dubious()), ['prompt' => 'МФО']) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'inn_cli')
            ->label(false)
            ->textInput(['maxlength' => true, 'placeholder' => 'ИНН']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'account_cli')
            ->label(false)
            ->textInput(['maxlength' => true, 'placeholder' => 'Счет']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'name_cli')
            ->label(false)
            ->textInput(['maxlength' => true, 'placeholder' => 'Наименование']) ?>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-2">
        <h5><b>Корреспондент</b></h5>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'mfo_cor')
            ->label(false)
            ->dropDownList(Correspondent::mfoList(new Dubious()), ['prompt' => 'МФО']) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'inn_cor')
            ->label(false)
            ->textInput(['maxlength' => true, 'placeholder' => 'ИНН']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'account_cor')
            ->label(false)
            ->textInput(['maxlength' => true, 'placeholder' => 'Счет']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'name_cor')
            ->label(false)
            ->textInput(['maxlength' => true, 'placeholder' => 'Наименование']) ?>
    </div>

    <div class="col-md-2">
        <h5><b>Параметры</b></h5>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'pop')
            ->textInput(['maxlength' => true, 'placeholder' => 'Назначение платежа'])
            ->label(false) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'ans_per')
            ->label(false)
            ->dropDownList(Params::ansPerList(new Dubious()), ['prompt' => 'Ответ исп.'])
        ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'currency')
            ->label(false)
            ->dropDownList(Params::currencyList(new Dubious()), ['prompt' => 'Валюта'])
        ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'criterion')
            ->label(false)
            ->dropDownList(Params::criterionList(new Dubious()), ['prompt' => 'Критерий'])
        ?>
    </div>

    <div class="col-md-2">
        <h5><b>Диапазон</b></h5>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <?= NumberControl::widget([
                'model' => $model,
                'displayOptions' => [
                    'placeholder' => 'Сумма документа от',
                ],
                'attribute' => 'sumStart',
                'maskedInputOptions' => [
                    'groupSeparator' => ' ',
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?= NumberControl::widget([
                'model' => $model,
                'displayOptions' => [
                    'placeholder' => 'Сумма документа до',
                ],
                'attribute' => 'sumEnd',
                'maskedInputOptions' => [
                    'groupSeparator' => ' ',
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'created_by')
            ->label(false)
            ->dropDownList(DubiousHelper::getUsersInGroup(Yii::$app->user->identity), ['prompt' => 'Все операторы'])
        ?>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-block btn-primary btn-flat']) ?>
        <?= Html::a('Очистить', '/dubious', ['class' => 'btn btn-block btn-default btn-flat']) ?>
    </div>

</div>
<?php ActiveForm::end(); ?>
