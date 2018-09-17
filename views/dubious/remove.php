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
                    <th>
                        <div class="checkbox">
                            <label for="allCheck">
                                <input type="checkbox" id="allCheck"> <b>Отметить</b>
                            </label>
                        </div>
                    </th>
                    <th><div class="checkbox">МФО клиента</div></th>
                    <th><div class="checkbox">Наименование клиента</div></th>
                    <th><div class="checkbox">Добавлено</div></th>
                    <th><div class="checkbox">Добавил</div></th>
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
        <?= Html::submitButton(Html::tag('i','',['class' => 'fa fa-trash']).' Удалить', [
            'class' => 'btn btn-flat btn-danger',
            'data-confirm' => 'Вы уверены, что хотите удалить эти элементы?'
        ]) ?>
    </div>
<?php ActiveForm::end(); ?>

<?php

$script = <<<JS
$("document").ready(function(){
    $('#allCheck').on('change', function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
});
JS;

$this->registerJs($script);
