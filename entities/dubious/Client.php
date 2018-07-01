<?php

namespace app\entities\dubious;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * Client
 * @property string $id_cli
 * @property string $mfo_cli
 * @property string $inn_cli
 * @property string $account_cli
 * @property string $name_cli
 */

Class Client
{
    public $id_cli;
    public $mfo_cli;
    public $inn_cli;
    public $account_cli;
    public $name_cli;

    public function __construct($id_cli, $mfo_cli, $inn_cli, $account_cli, $name_cli)
    {
        $this->id_cli = $id_cli;
        $this->mfo_cli = $mfo_cli;
        $this->inn_cli = $inn_cli;
        $this->account_cli = $account_cli;
        $this->name_cli = $name_cli;
        return $this;
    }


    public static function mfoList(Dubious $dubious){
        return ArrayHelper::map(
            $dubious->find()
            ->select('mfo_cli')
            ->distinct()
            ->asArray()
            ->all(),
            'mfo_cli',
            'mfo_cli');
    }



}