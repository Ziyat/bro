<?php

namespace app\repositories\user;


use app\entities\user\User;
use app\entities\user\UsersGroup;
use app\repositories\NotFoundException;
use yii\db\StaleObjectException;

class UserRepository
{
    public function get($id): User
    {
        if (!$user = User::findOne($id)) {
            throw new NotFoundException('User is not found.');
        }
        return $user;
    }
    public function getGroup($id): UsersGroup
    {
        if (!$group = UsersGroup::findOne($id)) {
            throw new NotFoundException('Group is not found.');
        }
        return $group;
    }

    public function save(User $user)
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function saveGroup(UsersGroup $group)
    {
        if (!$group->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(User $user)
    {
        if (!$user->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}