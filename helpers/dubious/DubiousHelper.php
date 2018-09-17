<?php


namespace app\helpers\dubious;


use app\entities\dubious\Dubious;
use app\entities\user\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

class DubiousHelper
{
    public static function currencyCodeToText($code)
    {
        $currency = [
            '36' => 'AUD',
            '40' => 'ATS',
            '56' => 'BEF',
            '826' => 'GBP',
            '124' => 'CAD',
            '203' => 'CZK',
            '208' => 'DKK',
            '528' => 'NLG',
            '233' => 'EEK',
            '978' => 'EUR',
            '246' => 'FIM',
            '250' => 'FRF',
            '276' => 'DEM',
            '300' => 'GRD',
            '344' => 'HKD',
            '348' => 'HUF',
            '372' => 'IEP',
            '380' => 'ITL',
            '392' => 'JPY',
            '428' => 'LVL',
            '440' => 'LTL',
            '484' => 'MXN',
            '554' => 'NZD',
            '578' => 'NOK',
            '985' => 'PLN',
            '620' => 'РТЕ',
            '643' => 'RUB',
            '702' => 'SGD',
            '703' => 'SKK',
            '710' => 'ZAR',
            '724' => 'ESP',
            '752' => 'SEK',
            '756' => 'CHF',
            '980' => 'UAH',
            '840' => 'USD',
            '000' => 'SUM',
        ];
        if (!empty($currency[$code])) {
            return $currency[$code];
        }

        return null;
    }


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

    public static function getUsersInGroup(User $currentUser, $ids = false)
    {
        if ($currentUser->is_admin) {
            if($ids) {
                $result = ArrayHelper::getColumn(
                    User::find()->select(['id', 'name'])
                        ->asArray()
                        ->all(), 'id');
            }else{
                $result = ArrayHelper::map(
                    User::find()->select(['id', 'name'])
                        ->asArray()
                        ->all(), 'id', 'name');
            }
            return $result;
        } else {
            if($ids){
                $result[] = $currentUser->id;
                foreach ($currentUser->groups as $group) {
                    if (!$group->parent_id || !empty($group->children)) {
                        foreach ($group->children as $child) {
                            foreach ($child->users as $user) {
                                $result[] = $user->id;
                            }
                        }

                    }
                }
            }else{
                $result[$currentUser->id] = $currentUser->name;
                foreach ($currentUser->groups as $group) {
                    if (!$group->parent_id || !empty($group->children)) {
                        foreach ($group->children as $child) {
                            foreach ($child->users as $user) {
                                $result[$user->id] = $user->name;
                            }
                        }

                    }
                }
            }
            return $result;
        }
        return $result;
    }


    public static function dateToTime($format, $date)
    {
        $newDate = [];

        $date = trim($date);
        $format = trim($format);

        $date = str_replace([".", "/", "-", " ", ""], '-', $date);
        $format = str_replace([".", "/", "-", " ", ""], '-', $format);

        $date = explode('-', $date);
        $format = explode('-', $format);

        foreach ($format as $k => $f) {
            if ($f == 'm' || $f == 'M') {
                $newDate['month'] = $date[$k];
            } elseif ($f == 'd' || $f == 'D') {
                $newDate['day'] = $date[$k];
            } elseif ($f == 'y' || $f == 'Y') {
                $newDate['year'] = $date[$k];
            }
        }
        return strtotime($newDate['year'] . '-' . $newDate['month'] . '-' . $newDate['day']);


    }

}