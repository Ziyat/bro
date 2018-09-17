<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace app\forms\dubious;


use app\entities\dubious\Date;
use yii\base\Model;

class DateForm extends Model
{
    public $date_doc;
    public $date_msg;

    private $_date;

    public function __construct(Date $date = null, array $config = [])
    {
        if ($date) {
            $this->date_doc = $date->date_doc;
            $this->date_msg = $date->date_msg;
            $this->_date = $date;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['date_msg', 'date_doc'], 'date', 'format' => 'php: d.m.Y'],
        ];
    }
}