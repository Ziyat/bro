<?php
namespace app\forms\dubious;


use app\entities\dubious\Dubious;
use app\helpers\dubious\DubiousHelper;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * DubiousForm
 *@property int $id
 * @property string $id_cli
 * @property string $mfo_cli
 * @property string $inn_cli
 * @property string $account_cli
 * @property string $name_cli
 * @property string $mfo_cor
 * @property string $inn_cor
 * @property string $account_cor
 * @property string $name_cor
 * @property string $date_msg
 * @property string $date_doc
 * @property string $doc_sum
 * @property string $pop
 * @property string $ans_per
 * @property string $currency
 * @property string $criterion
 */
class DubiousForm extends Model
{
    public $id_cli;
    public $mfo_cli;
    public $inn_cli;
    public $account_cli;
    public $name_cli;
    public $mfo_cor;
    public $inn_cor;
    public $account_cor;
    public $name_cor;
    public $date_msg;
    public $date_doc;
    public $doc_sum;
    public $pop;
    public $ans_per;
    public $currency;
    public $criterion;
    private $_dubious;

    public function __construct(Dubious $dubious = null,$config = [])
    {

        if($dubious){
            $this->id_cli = $dubious->id_cli;
            $this->mfo_cli = $dubious->mfo_cli;
            $this->inn_cli = $dubious->inn_cli;
            $this->account_cli = $dubious->account_cli;
            $this->name_cli = $dubious->name_cli;
            $this->mfo_cor = $dubious->mfo_cor;
            $this->inn_cor = $dubious->inn_cor;
            $this->account_cor = $dubious->account_cor;
            $this->name_cor = $dubious->name_cor;
            $this->date_msg = $dubious->date_msg;
            $this->date_doc = $dubious->date_doc;
            $this->doc_sum = $dubious->doc_sum;
            $this->pop = $dubious->pop;
            $this->ans_per = $dubious->ans_per;
            $this->currency = $dubious->currency;
            $this->criterion = $dubious->criterion;
            $this->_dubious = $dubious;
        }else{
            $this->_dubious = new Dubious();
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_msg', 'date_doc', 'doc_sum','id_cli', 'mfo_cli', 'inn_cli', 'account_cli', 'name_cli', 'mfo_cor', 'inn_cor', 'account_cor', 'name_cor', 'pop', 'ans_per', 'currency', 'criterion'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return DubiousHelper::attributeLabels();
    }
}