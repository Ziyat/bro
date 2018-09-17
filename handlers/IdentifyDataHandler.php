<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace app\handlers;

class IdentifyDataHandler
{


    public function isCorInn($str)
    {
        $str = $this->strToClear($str);

        similar_text($str,'инн корреспондента', $percent);
        return $this->isCoincides($percent);
    }

    public function isClientInn($str)
    {
        $str = $this->strToClear($str);

        similar_text($str,'инн клиента', $percent);
        return $this->isCoincides($percent);
    }

    public function isDocumentSum($str)
    {
        $str = $this->strToClear($str);

        similar_text($str,'сумма документа', $percent);
        return $this->isCoincides($percent);
    }

    public function isPurposeOfPayment($str)
    {
        $str = $this->strToClear($str);

        similar_text($str,'назначение платежа', $percent);
        return $this->isCoincides($percent);
    }

    public function isMfo($str)
    {
        $str = $this->strToClear($str);
        similar_text($str, 'мфо', $variant[1]);
        similar_text($str, 'мфо клиента', $variant[2]);
        similar_text($str, 'мфо корреспондента', $variant[3]);
        return $this->isCoincides(max($variant));
    }

    public function isAnswerPerformer($str)
    {
        $str = $this->strToClear($str);

        similar_text($str,'ответ исполнитель', $percent);
        return $this->isCoincides($percent);
    }

    public function isCriterion($str)
    {
        $str = $this->strToClear($str);

        similar_text($str, 'критерий', $variant[1]);
        similar_text($str, 'состояние', $variant[2]);

        return $this->isCoincides(max($variant));
    }

    public function isDateDocument($str)
    {
        $str = $this->strToClear($str);

        similar_text($str,'дата проводки', $percent);
        return $this->isCoincides($percent);
    }

    public function isDateMsg($str)
    {
        $str = $this->strToClear($str);

        similar_text($str, 'дата сообщения', $variant[1]);
        similar_text($str, 'дата док.', $variant[2]);

        return $this->isCoincides(max($variant));
    }

    public function isCorName($str)
    {
        $str = $this->strToClear($str);
        similar_text($str, 'наименование корреспондента', $percent);
        return $this->isCoincides($percent);
    }

    public function isCorAccount($str)
    {
        $str = $this->strToClear($str);
        similar_text($str, 'счет корреспондента', $percent);
        return $this->isCoincides($percent);
    }

    public function isClientName($str)
    {
        $str = $this->strToClear($str);
        similar_text($str, 'наименование клиента', $percent);
        return $this->isCoincides($percent);
    }

    public function isClientAccount($str)
    {
        $str = $this->strToClear($str);
        similar_text($str, 'счет клиента', $percent);
        return $this->isCoincides($percent);
    }

    public function isBankAccount($account)
    {
        return strlen($account) === 20;
    }

    private function isCoincides($percent)
    {
        return $percent > 90;
    }

    private function strToClear($str)
    {
        $str = trim($str);
        $str = mb_strtolower($str,'UTF-8');

        return $str;
    }
}