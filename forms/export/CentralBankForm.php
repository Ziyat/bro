<?php

namespace app\forms\export;

use yii\base\Model;

/**
 * Class CentralBankForm
 * @package app\forms\export
 * @property $date
 */

class CentralBankForm extends Model
{
    public $date;

    public function rules()
    {
        return[
            ['date','required'],
            ['date','date','format' => 'php:Y-m'],
        ];
    }

}