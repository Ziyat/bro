<?php


namespace app\helpers\dubious;


use app\entities\dubious\Dubious;
use app\entities\user\User;
use app\entities\user\UsersAssignment;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use yii\helpers\VarDumper;

class DubiousHelper
{
    public static function alphabet()
    {
        return [
            'A',
            'B',
            'С',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
        ];
    }

    public static function attributeLabels($form = false)
    {

        $baseAttributes = [
            'id' => 'ID',
            'created_at' => 'Добавлено',
            'created_by' => 'Добавил',
            'updated_at' => 'Обновлено',
            'updated_by' => 'Обновил',
        ];

        $dubiousAttributes = [
            'id_cli' => 'ID клиента',
            'mfo_cli' => 'МФО клиента',
            'inn_cli' => 'ИНН клиента',
            'account_cli' => 'Счет клиента',
            'name_cli' => 'Наименование клиента',
            'mfo_cor' => 'МФО корреспондента',
            'inn_cor' => 'ИНН корреспондента',
            'account_cor' => 'Счет корреспондента',
            'name_cor' => 'Наименование корреспондента',
            'date_msg' => 'Дата сообщения',
            'date_doc' => 'Дата проводки',
            'doc_sum' => 'Сумма документа',
            'pop' => 'Назначение платежа',
            'ans_per' => 'Ответ исполнитель',
            'currency' => 'Валюта',
            'criterion' => 'Критерий',
        ];
        return $form ? $dubiousAttributes : array_merge($baseAttributes, $dubiousAttributes);
    }

    public static function getControlButtons($id, $user_id)
    {
        $ids = self::getPreviousAndNextId($id, $user_id);

        $buttons[] = $ids['prev'] ? Html::a(
            '<i class="fa fa-chevron-left"></i>',
            Url::to(['dubious/view', 'id' => $ids['prev']]),
            [
                'class' => 'btn btn-flat btn-default'
            ]) : '';
        $buttons[] = Html::tag('i', $ids['details'],
            [
                'type' => 'button',
                'class' => 'btn btn-flat btn-default',
                'disabled' => 'disabled',
            ]);
        $buttons[] = $ids['next'] ? Html::a(
            '<i class="fa fa-chevron-right"></i>',
            Url::to(['dubious/view', 'id' => $ids['next']]),
            [
                'class' => 'btn btn-flat btn-default'
            ]) : '';

        return $buttons;
    }

    public static function getPreviousAndNextId($id, $user_id)
    {

        $ids = ArrayHelper::getColumn(Dubious::find()->select('id')->where([
            'created_by' => $user_id
        ])->asArray()->all(), 'id');

        foreach ($ids as $k => $v) {
            if ($v == $id) {
                $current = $k + 1;
                $prev = empty($ids[$k - 1]) ? false : $ids[$k - 1];
                $next = empty($ids[$k + 1]) ? false : $ids[$k + 1];
            }
        }

        return [
            'details' => $current . '/' . count($ids),
            'prev' => $prev,
            'next' => $next
        ];
    }

    public static function getUsersInGroup($currentUser, UsersAssignment $assignment)
    {
        if ($currentUser->is_admin) {
            $result = User::find()->select('id')->asArray()->all();
        } else {
            $groups = ArrayHelper::getColumn($currentUser->assignments, 'id');
            $result = ArrayHelper::getColumn($assignment::findAll(['group_id' => $groups]), 'user_id');
        }
        return $result == [] ? $currentUser->id : $result;
    }


    public static function dateToTime($format, $date)
    {
        $newDate = [];

        $date = trim($date);
        $format = trim($format);

        $date = str_replace([".","/","-"," ",""],'-',$date);
        $format = str_replace([".","/","-"," ",""],'-',$format);

        $date = explode('-', $date);
        $format = explode('-', $format);

        foreach ($format as $k => $f)
        {
            if($f == 'm' || $f == 'M'){
                $newDate['month'] = $date[$k];
            }elseif($f == 'd' || $f == 'D'){
                $newDate['day'] = $date[$k];
            }elseif($f == 'y' || $f == 'Y'){
                $newDate['year'] = $date[$k];
            }
        }
        return strtotime($newDate['year'] . '-' . $newDate['month'] . '-' . $newDate['day']);


    }

}