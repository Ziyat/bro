<?php

namespace app\forms;


use yii\base\Model;

/**
 * Class LogForm
 * @package app\forms
 *
 * @property string $action
 * @property string $description
 * @property int $user_id
 */

class LogForm extends Model
{

    public $action;
    public $description;
    public $user_id;

    public function rules()
    {
        return [
            [['description'], 'string'],
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['action'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

}