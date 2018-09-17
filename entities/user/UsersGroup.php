<?php

namespace app\entities\user;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%users_group}}".
 *
 * @property int $id
 * @property string $name
 * @property integer $parent_id
 *
 * @property UserAssignments[] $userAssignments
 * @property User[] $users
 * @property self $parent
 * @property self $children
 */
class UsersGroup extends ActiveRecord
{
    public static function create($name, $parentId)
    {
        $user = new static();
        $user->name = $name;
        $user->parent_id = $parentId;
        return $user;
    }

    public function edit($name, $parentId)
    {
        $this->name = $name;
        $this->parent_id = $parentId;
    }


    public function setUser($user_id)
    {
        $assignments = $this->userAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForUser($user_id)) {
                return;
            }
        }
        $assignments[] = UsersAssignment::create($user_id);
        $this->userAssignments = $assignments;
    }

    public function revokeUsers()
    {
        $this->userAssignments = [];
    }




    public function getParent(): ActiveQuery
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    public function getChildren(): ActiveQuery
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }


    public function getUserAssignments(): ActiveQuery
    {
        return $this->hasMany(UsersAssignment::class, ['group_id' => 'id']);
    }

    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->via('userAssignments');
    }


    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['userAssignments'],
            ],
        ];
    }

    public static function tableName()
    {
        return '{{%users_group}}';
    }
}
