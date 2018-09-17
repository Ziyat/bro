<?php

namespace app\services\user;


use app\entities\user\UsersGroup;
use app\forms\user\UsersGroupForm;
use app\repositories\user\UserGroupRepository;
use app\services\TransactionManager;


/**
 * Class UserGroupService
 *
 * @package app\services\user
 * @property UserGroupRepository $groups
 * @property TransactionManager $transaction
 */
class UserGroupService
{
    private $groups;
    private $transaction;

    public function __construct(UserGroupRepository $groups, TransactionManager $transactionManager)
    {
        $this->groups = $groups;
        $this->transaction = $transactionManager;
    }

    public function create(UsersGroupForm $form)
    {
        $group = UsersGroup::create($form->name, $form->parentId);
        try {
            $this->transaction->wrap(function () use ($group, $form) {
                if (!empty($form->users)) {
                    foreach ($form->users as $userId) {
                        $group->setUser($userId);
                    }
                }
                $this->groups->save($group);
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $group;
    }

    public function edit($id, UsersGroupForm $form)
    {
        $group = $this->groups->get($id);

        try {
            $this->transaction->wrap(function () use ($group, $form) {
                $group->revokeUsers();
                $this->groups->save($group);

                $group->edit($form->name, $form->parentId);

                if (!empty($form->users)) {
                    foreach ($form->users as $userId) {
                        $group->setUser($userId);
                    }
                }

                $this->groups->save($group);
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }


        return $group;
    }
}