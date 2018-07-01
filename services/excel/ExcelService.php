<?php

namespace app\services\excel;

use app\entities\excel\ExcelTemplates;
use app\forms\excel\TemplatesForm;
use app\repositories\excel\ExcelRepository;
use yii\helpers\Json;
use yii\helpers\VarDumper;

class ExcelService
{
    private $excels;

    public function __construct(ExcelRepository $repository)
    {
        $this->excels = $repository;
    }

    /**
     * @param UserForm $form
     * @return User
     */

    public function create(TemplatesForm $form)
    {
        $template = ExcelTemplates::create($form->name, Json::encode($form->values));
        $this->excels->save($template);
        return $template;
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

    public function remove($id)
    {
        $user = $this->repository->get($id);
        $this->repository->remove($user);
    }
}