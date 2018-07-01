<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\user\UserHelper;

/* @var $this yii\web\View */
/* @var $model app\forms\user\UsersGroupForm */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="col-md-4">
    <div class="box">
        <div class="box-header">
            <div class="box-title">Основное</div>
        </div>
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <div style="height: 200px; overflow-y: scroll; margin-bottom: 20px;">
                <?= $form->field($model, 'users')
                    ->label(false)
                    ->checkboxList(UserHelper::usersList(),
                        [
                            'item' => function ($index, $label, $name, $checked, $value) {
                                $options = array_merge(['label' => $label, 'value' => $value], []);
                                return '<div class="checkbox">' . Html::checkbox($name, $checked, $options) . '</div>';
                            }
                        ]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat btn-block']) ?>
            </div>
        </div>
    </div>

</div>


<?php ActiveForm::end(); ?>

