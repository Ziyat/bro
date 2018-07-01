<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\entities\user\User;
use yii\widgets\ListView;
use app\helpers\dubious\DubiousHelper;
use app\entities\user\UsersAssignment;

?>


<?php $form = ActiveForm::begin(); ?>
    <div class="box">
        <div class="box-body">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Отметить</th>
                    <th>МФО клиента</th>
                    <th>Наименование клиента</th>
                    <th>Добавлено</th>
                    <th>Добавил</th>
                </tr>
                </thead>
                <tbody>
                <?=
                ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_dubious',
                    'layout' => ""
                        . "{items}"
                        . "<div class=\"box-footer\">{pager}</div>",
                ])
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Удалить', [
            'class' => 'btn btn-flat btn-danger',
            'data-confirm' => 'Вы уверены, что хотите удалить эти элементы?'
        ]) ?>
    </div>
<?php ActiveForm::end(); ?>