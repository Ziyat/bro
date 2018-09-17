<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace app\forms\dubious;


use app\entities\dubious\Correspondent;
use yii\base\Model;

class CorrespondentForm extends Model
{
    public $mfo_cor;
    public $inn_cor;
    public $account_cor;
    public $name_cor;

    private $_correspondent;

    public function __construct(Correspondent $correspondent = null, array $config = [])
    {
        if ($correspondent) {
            $this->mfo_cor = $correspondent->mfo_cor;
            $this->inn_cor = $correspondent->inn_cor;
            $this->account_cor = $correspondent->account_cor;
            $this->name_cor = $correspondent->name_cor;
            $this->_correspondent = $correspondent;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['mfo_cor', 'name_cor'], 'string', 'max' => 255],
            [['inn_cor', 'account_cor'], 'integer'],
        ];
    }
}