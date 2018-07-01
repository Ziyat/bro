<?php

namespace app\entities\user;

use Yii;

/**
 * This is the model class for table "users_assignment".
 *
 * @property int $user_id
 * @property int $group_id
 *
 * @property UsersGroup $group
 * @property User $user
 */
class UsersAssignment extends \yii\db\ActiveRecord
{


    public static function create($user_id, $group_id)
    {
        $usersAssignment = new static();
        $usersAssignment->user_id = $user_id;
        $usersAssignment->group_id = $group_id;
        return $usersAssignment;
    }
    public function edit($user_id, $group_id)
    {
        $this->user_id = $user_id;
        $this->group_id = $group_id;
    }



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users_assignment}}';
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(UsersGroup::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
