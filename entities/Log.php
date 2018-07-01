<?php

namespace app\entities;

use app\forms\LogForm;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property string $action
 * @property string $description
 * @property int $user_id
 * @property integer $created_at
 *
 * @property Users $user
 */
class Log extends \yii\db\ActiveRecord
{

    public static function create(LogForm $form): self
    {

        $log = new static();
        $log->action = $form->action;
        $log->description = $form->description;
        $log->user_id = $form->user_id;
        return $log;
    }

    public static function tableName()
    {
        return '{{%log}}';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],

        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'action' => 'Action',
            'description' => 'Description',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}
