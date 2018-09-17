<?php

namespace app\forms\dubious;


use app\entities\dubious\Client;
use app\entities\dubious\Correspondent;
use app\entities\dubious\Date;
use app\entities\dubious\Dubious;
use app\entities\dubious\Params;
use app\helpers\dubious\DubiousHelper;
use app\forms\CompositeForm;
use app\forms\dubious\ClientForm;
use app\forms\dubious\CorrespondentForm;
use app\forms\dubious\DateForm;
use app\forms\dubious\ParamsForm;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * DubiousForm
 * @property int $id
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
 *
 */
class DubiousForm extends CompositeForm
{
    public function __construct(Dubious $dubious = null,$post = null, $config = [])
    {
        parent::__construct($config);
    }


    public function attributeLabels()
    {
        return DubiousHelper::attributeLabels();
    }

    public function internalForms(): array
    {
        return [];
    }
}