<?php
    $user = \app\entities\user\User::find()->select('name')->where(['id' => $model->created_by])->one();
?>
<tr>
    <td>
        <div class="checkbox">
        <label for="<?= $model->id ?>">
            <input type="checkbox" id="<?= $model->id ?>" name="Dubious[]" value="<?= $model->id ?>">
            ID <?= $model->id ?>
        </label>
        </div>
    </td>
    <td><?= $model->mfo_cli ?></td>
    <td><?= $model->name_cli ?></td>
    <td><?= Yii::$app->formatter->asDate($model->created_at) ?></td>
    <td><?= $user->name ?></td>
</tr>



