<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\entities\Reports */
/* @var $form yii\widgets\ActiveForm */
?>




<?php $form = ActiveForm::begin(); ?>
<div class="col-lg-6">

    <?php

    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'start_date',
        'attribute2' => 'end_date',
        'options' => ['placeholder' => 'Дата начала', 'style' => 'border-radius: 0;'],
        'options2' => ['placeholder' => 'Дата окончания', 'style' => 'border-radius: 0!important;'],
        'type' => DatePicker::TYPE_RANGE,
        'form' => $form,
        'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'autoclose' => true,
        ]
    ]);

    ?>
</div>

<div class="form-group">
    <?= Html::submitButton('Экспорт файла', ['class' => 'btn btn-success btn-flat']) ?>
</div>

<?php ActiveForm::end(); ?>

