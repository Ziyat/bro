<?php

namespace app\entities\dubious;
/**
 * Date.
 *
 * @property string $date_msg
 * @property string $date_doc
 */

Class Date
{
    public $date_msg;
    public $date_doc;

    public function __construct($date_msg = null, $date_doc = null)
    {
        $this->date_msg = $date_msg;
        $this->date_doc = $date_doc;
        return $this;
    }



}