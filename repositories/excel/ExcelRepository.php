<?php

namespace app\repositories\excel;


use app\entities\excel\ExcelTemplates;
use app\repositories\NotFoundException;

class ExcelRepository
{
    public function get($id): ExcelTemplates
    {
        if (!$templates = ExcelTemplates::findOne($id)) {
            throw new NotFoundException('User is not found.');
        }
        return $templates;
    }

    public function save(ExcelTemplates $templates)
    {
        if (!$templates->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(ExcelTemplates $templates)
    {
        if (!$templates->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}