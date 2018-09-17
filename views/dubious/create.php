<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $forms app\forms\dubious\DubiousForm */

$this->title = 'Создать сомнителя';
$this->params['breadcrumbs'][] = ['label' => 'сомнительные', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dubious-create">
    <p>Paste excel data here:</p>
    <textarea name="excel_data" style="width:250px;height:150px;"></textarea><br>
    <input type="button" onclick="javascript:generateTable()" value="Genereate Table"/>
    <br><br>
    <p>Table data will appear below</p>
    <hr>
    <?php $form = ActiveForm::begin(['id' => 'form']); ?>

    <?php ActiveForm::end(); ?>
    <script>
        function generateTable() {
            var data = $('textarea[name=excel_data]').val();
            var inputs = data.split("\n");
            var groups = $('<div />');
            for (var y in inputs) {
                var cells = inputs[y].split("\t");
                var group = $('<hr><div />');
                for (var x in cells) {
                    var nameAndLabel = getKey(x);
                    var inner = $('<div class="form-group" />');
                    var helpBlock = $('<div class="help-block" />');
                    var label = $('<label class="control-label" for="' + nameAndLabel[0] + '">' + nameAndLabel[1] + '</label>');
                    inner.append(label);
                    inner.append($('<input id="' + nameAndLabel[0] + '" name="' + nameAndLabel[0] + '[' + y + '][' + nameAndLabel[2] + ']" class="form-control">').val(cells[x]));
                    inner.append(helpBlock);
                    group.append(inner);
                }
                groups.append(group);
            }
            // Insert into DOM
            $('#form').append($('<button type="submit" class="btn btn-flat btn-success">Отправить</button>'));
            $('#form').append(groups);
        }


        function getKey(number) {
            switch (parseInt(number)) {
                case 0:
                    return ['ClientForm', 'ID клиента', 'id_cli'];
                case 1:
                    return ['DateForm', 'Дата сообщения', 'date_msg'];
                case 2:
                    return ['ClientForm', 'МФО Клиента', 'mfo_cli'];
                case 3:
                    return ['ClientForm', 'ИНН Клиента', 'inn_cli'];
                case 4:
                    return ['ClientForm', 'Счет Клиента', 'account_cli'];
                case 5:
                    return ['ClientForm', 'Нименование Клиента', 'name_cli'];
                case 6:
                    return ['CorrespondentForm', 'МФО Корреспондента', 'mfo_cor'];
                case 7:
                    return ['CorrespondentForm', 'Счет Корреспондента', 'account_cor'];
                case 8:
                    return ['CorrespondentForm', 'ИНН Корреспондента', 'inn_cor'];
                case 9:
                    return ['CorrespondentForm', 'Нименование Корреспондента', 'name_cor'];
                case 10:
                    return ['ParamsForm', 'Сумма документа', 'doc_sum'];
                case 11:
                    return ['ParamsForm', 'Валюта', 'currency'];
                case 12:
                    return ['ParamsForm', 'Назначение платежа', 'pop'];
                case 13:
                    return ['DateForm', 'Дата проводки', 'date_doc'];
                case 14:
                    return ['ParamsForm', 'Критерий', 'criterion'];
                case 15:
                    return ['ParamsForm', 'Ответ исполнитель', 'ans_per'];
                default:
                    return ['unknown', 'unknown'];
            }
        }
    </script>

</div>
