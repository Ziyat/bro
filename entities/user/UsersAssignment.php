<?php

namespace app\entities\user;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "users_assignment".
 *
 * @property int $user_id
 * @property int $group_id
 *
 * @property UsersGroup $group
 * @property User $user
 */
class UsersAssignment extends ActiveRecord
{


    public static function create($user_id = null, $group_id = null)
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


    public function isForUser($userId): bool
    {
        return $this->user_id == $userId;
    }

    public function isForGroup($groupId): bool
    {
        return $this->group_id == $groupId;
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
        return $this->hasOne(UsersGroup::class, ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id']);
    }
}
