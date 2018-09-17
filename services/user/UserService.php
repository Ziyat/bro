<?php

namespace app\services\user;


use app\entities\user\User;
use app\forms\user\UserForm;
use app\repositories\user\UserRepository;
use app\services\TransactionManager;


/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class UserService
 * @package app\services\user
 * @property UserRepository $users
 * @property TransactionManager $transaction
 */
class UserService
{
    private $users;
    private $transaction;

    public function __construct(
        UserRepository $users,
        TransactionManager $transactionManager
    )
    {
        $this->users = $users;
        $this->transaction = $transactionManager;
    }

    /**
     * @param UserForm $form
     * @return User
     */

    public function create(UserForm $form)
    {
        $user = User::create($form->name, $form->username,$form->password,$form->status);
        try {
            $this->transaction->wrap(function () use ($user, $form) {
                if (!empty($form->groups)) {
                    foreach ($form->groups as $groupId) {
                        $user->setGroup($groupId);
                    }
                }
                $this->users->save($user);
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $user;
    }

    /**
     * @param UserForm $form
     * @return User
     */
    public function edit($id, UserForm $form)
    {
        $user = $this->users->get($id);

        try {
            $this->transaction->wrap(function () use ($user, $form) {
                $user->revokeGroups();
                $this->users->save($user);
                $user->edit($form->name, $form->username, $form->password, $form->status);
                if (!empty($form->groups)) {
                    foreach ($form->groups as $groupId) {
                        $user->setGroup($groupId);
                    }
                }
                $this->users->save($user);
            });
        } catch (\RuntimeException $e) {
            throw new \RuntimeException($e->getMessage());
        }

        return $user;
    }

    public function activate($id)
    {
        $user = $this->users->get($id);
        $user->activate();
        $this->users->save($user);
    }

    public function deactivate($id)
    {
        $user = $this->users->get($id);
        $user->deactivate();
        $this->users->save($user);
    }

    public function remove($id)
    {
        $user = $this->users->get($id);
        $this->users->remove($user);
    }
}