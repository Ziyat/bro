<?php
/**
 * Created by Madetec-Solution OK.
 * Developer: Mirkhanov Z.S.
 * Date: 19.06.2018
 */

use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

?>

<div class="col-md-4">
<?php ActiveForm::begin(); ?>

<label class="control-label">Отчет для ЦБ</label>
<?php
$layout = <<< HTML
{picker}{remove}{input}
<span class="input-group-btn">
<button type="submit" class="btn btn-default">
<i class="fa fa-download"></i>
</button>
</span>
HTML;

echo DatePicker::widget([
    'model' => $form,
    'attribute' => 'date',
    'value' => date('Y-m'),
    'layout' => $layout,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm'
    ]
]);


?>

<?php ActiveForm::end(); ?>
</div>