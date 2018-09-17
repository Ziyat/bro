<?php

namespace app\entities\dubious;
use yii\helpers\ArrayHelper;

/**
 * Correspondent.
 *
 * @property string $mfo_cor
 * @property string $inn_cor
 * @property string $account_cor
 * @property string $name_cor
 */

Class Correspondent
{
    public $mfo_cor;
    public $inn_cor;
    public $account_cor;
    public $name_cor;

    public function __construct($mfo_cor=null, $inn_cor=null, $account_cor=null, $name_cor=null)
    {
        $this->mfo_cor = $mfo_cor;
        $this->inn_cor = $inn_cor;
        $this->account_cor = $account_cor;
        $this->name_cor = $name_cor;
        return $this;
    }

    public static function mfoList(Dubious $dubious){
        return ArrayHelper::map(
            $dubious->find()
                ->select('mfo_cor')
                ->distinct()
                ->asArray()
                ->all(),
            'mfo_cor',
            'mfo_cor');
    }

}