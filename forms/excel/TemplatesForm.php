<?php

namespace app\forms\excel;


use yii\base\Model;

class TemplatesForm extends Model
{
    public $name;
    public $values;

    public function rules()
    {
        return [
            [['values'], 'each', 'rule' => ['string']],
            [['name'], 'string', 'max' => 255],
            [['name'], 'required'],
        ];
    }
}