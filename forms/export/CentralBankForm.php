<?php

namespace app\forms\export;

use kartik\daterange\DateRangeBehavior;
use yii\base\Model;

/**
 * Class CentralBankForm
 * @package app\forms\export
 * @property $rangeDate
 * @property $startDate
 * @property $endDate
 */

class CentralBankForm extends Model
{
    public $rangeDate;
    public $startDate;
    public $endDate;

    public function rules()
    {
        return[
            [['rangeDate'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'rangeDate',
                'dateStartAttribute' => 'startDate',
                'dateEndAttribute' => 'endDate',
            ]
        ];
    }

}