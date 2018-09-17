<?php

namespace app\repositories\user;


use app\entities\user\User;
use app\entities\user\UsersGroup;
use app\repositories\NotFoundException;
use yii\db\StaleObjectException;

class UserGroupRepository
{
    public function get($id): UsersGroup
    {
        if (!$group = UsersGroup::findOne($id)) {
            throw new NotFoundException('Group is not found.');
        }
        return $group;
    }

    public function save(UsersGroup $group)
    {
        if (!$group->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(UsersGroup $group)
    {
        if (!$group->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}