<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace app\forms\dubious;


use app\entities\dubious\Params;
use yii\base\Model;

class ParamsForm extends Model
{
    public $pop;
    public $ans_per;
    public $currency;
    public $criterion;
    public $doc_sum;

    private $_params;

    public function __construct(Params $params = null, array $config = [])
    {
        if($params){
            $this->pop = $params->pop;
            $this->ans_per = $params->ans_per;
            $this->currency = $params->currency;
            $this->criterion = $params->criterion;
            $this->doc_sum = $params->doc_sum;

            $this->_params = $params;
        }
        parent::__construct($config);
    }
    public function rules()
    {
        return [
            [['pop', 'ans_per', 'currency'], 'string', 'max' => 255],
            [['doc_sum','criterion','pop', 'ans_per', 'currency'], 'trim'],
            [['doc_sum','criterion'], 'number']
        ];
    }

}