<?php

namespace app\services;

use app\entities\Log;
use app\forms\LogForm;
use yii\helpers\VarDumper;

class LogService
{
    public function create(LogForm $form): void
    {
        $log = Log::create($form);
        $log->save();
    }
}