<?php

namespace app\entities\dubious;

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

    public function __construct($pop, $ans_per, $currency, $criterion, $doc_sum)
    {
        $this->pop = $pop;
        $this->ans_per = $ans_per;
        $this->currency = $currency;
        $this->criterion = $criterion;
        $this->doc_sum = $doc_sum;
        return $this;
    }

}