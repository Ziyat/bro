<?php

namespace app\entities\dubious;

use yii\helpers\ArrayHelper;

/**
 * Params.
 *
 * @property int $doc_sum
 * @property string $pop
 * @property string $ans_per
 * @property string $currency
 * @property string $criterion
 */
Class Params
{
    public $pop;
    public $ans_per;
    public $currency;
    public $criterion;
    public $doc_sum;

    public function __construct($pop = null, $ans_per = null, $currency = null, $criterion = null, $doc_sum = null)
    {
        $this->pop = $pop;
        $this->ans_per = $ans_per;
        $this->currency = $currency;
        $this->criterion = $criterion;
        $this->doc_sum = $doc_sum;
        return $this;
    }

    public static function ansPerList(Dubious $dubious)
    {
        return ArrayHelper::map(
            $dubious->find()
                ->select('ans_per')
                ->distinct()
                ->asArray()
                ->all(),
            'ans_per',
            'ans_per');
    }

    public static function currencyList(Dubious $dubious)
    {
        return ArrayHelper::map(
            $dubious->find()
                ->select('currency')
                ->distinct()
                ->asArray()
                ->all(),
            'currency',
            'currency');
    }

    public static function criterionList(Dubious $dubious)
    {
        return ArrayHelper::map(
            $dubious->find()
                ->select('criterion')
                ->distinct()
                ->asArray()
                ->all(),
            'criterion',
            'criterion');
    }

}