<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\dubious\DubiousHelper;
use yii\helpers\ArrayHelper;

$dubiousParametrs = DubiousHelper::attributeLabels(true);
$alphabet = DubiousHelper::alphabet();
/* @var $this yii\web\View */
/* @var $model app\entities\ExcelTemplates */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="box">
    <div class="box-body">
        <div class="table-responsive">


            <table class="table">
                <thead>
                <tr>
                    <?php for ($i = 0; $i < count($dubiousParametrs); $i++): ?>

                        <th><?= $alphabet[$i] ?></th>

                    <?php endfor; ?>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php for ($i = 0; $i < count($dubiousParametrs); $i++): ?>
                        <td>
                            <?= $form->field($model, 'values[' . $alphabet[$i] . ']')
                                ->dropDownList($dubiousParametrs, ['style' => 'width: 185px'])
                                ->label(false) ?>
                        </td>
                    <?php endfor; ?>

                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-flat btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
