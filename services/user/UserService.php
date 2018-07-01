<?php

namespace app\services\user;


use app\entities\user\User;
use app\entities\user\UsersGroup;
use app\forms\user\UserForm;
use app\forms\user\UsersGroupForm;
use app\repositories\user\UserRepository;
use yii\helpers\VarDumper;

class UserService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UserForm $form
     * @return User
     */

    public function create(UserForm $form)
    {
        $user = User::create($form->name, $form->username,$form->password,$form->status);

        $this->repository->save($user);
        return $user;
    }

    /**
     * @param UserForm $form
     * @return User
     */
    public function edit($id,UserForm $form)
    {
        $user = $this->repository->get($id);
        $user->edit($form->name, $form->username,$form->password,$form->status);

        $this->repository->save($user);
        return $user;
    }

    /**
     * @param UsersGroupForm $form
     * @return UsersGroup
     */
    public function createGroup(UsersGroupForm $form)
    {
        $group = UsersGroup::create($form->name,$form->users);
        $this->repository->saveGroup($group);
        return $group;
    }

    /**
     * @param UsersGroupForm $form
     * @return UsersGroup
     */
    public function editGroup($id, UsersGroupForm $form)
    {
        $group = $this->repository->getGroup($id);
        $group->edit($form->name, $form->users);

        $this->repository->saveGroup($group);
        return $group;
    }

    public function activate($id)
    {
        $user = $this->repository->get($id);
        $user->activate();
        $this->repository->save($user);
    }

    public function deactivate($id)
    {
        $user = $this->repository->get($id);
        $user->deactivate();
        $this->repository->save($user);
    }

    public function remove($id)
    {
        $user = $this->repository->get($id);
        $this->repository->remove($user);
    }
}