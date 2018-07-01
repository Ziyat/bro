<?php

namespace app\entities\user;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "users_group".
 *
 * @property int $id
 * @property string $name
 *
 * @property UsersAssignment[] $users
 */
class UsersGroup extends \yii\db\ActiveRecord
{
    public $users;
    public static function create($name,$users)
    {
        $user = new static();
        $user->name = $name;
        $user->users = $users;
        return $user;
    }
    public function edit($name,$users)
    {
        $this->name = $name;
        $this->users = $users;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $assign = new UsersAssignment();
        $assign->deleteAll([
            'group_id' => $this->id,
        ]);

        if($this->users){
            foreach ($this->users as $user){
                $assignment = UsersAssignment::create($user, $this->id);
                $assignment->save();
            }
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users_group}}';
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignments()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('users_assignment',['group_id' => 'id']);
    }
}
