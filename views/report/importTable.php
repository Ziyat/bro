<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="box">
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <?php $form = ActiveForm::begin(); ?>
                <div class="form-group">
                    <?= Html::submitButton('Импортировать', ['class' => 'btn btn-flat btn-success']) ?>
                </div>
                <?php foreach ($file['import'] as $k => $value): ?>
                <thead>
                    <tr>
                        <th></th>
                        <?php foreach ($value as $key => $v): ?>
                        <th><input type='checkbox' value='value[<?= $key ?>]' checked> <?= $key ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <?php break; endforeach; ?>

                <?php foreach ($file['import'] as $k => $value): ?>

                <tbody>
                <tr>
                    <td><input type="checkbox" value="key[<?= $k ?>]" checked></td>

                    <?php foreach ($value as $key => $v): ?>
                    <td class='<?= $v ?: 'bg-danger'; ?>'><?= $v ?></td>
                    <?php endforeach; ?>
                </tr>
                <tbody>
                <?php  endforeach; ?>
                <?php ActiveForm::end(); ?>
            </table>
        </div>
    </div>
</div>

