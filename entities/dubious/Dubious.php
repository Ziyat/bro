<?php

namespace app\entities\dubious;

use app\entities\dubious\Client;
use app\entities\dubious\Correspondent;
use app\entities\dubious\Date;
use app\entities\user\User;
use app\helpers\dubious\DubiousHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "dubious".
 *
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
 * @property string $file
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class Dubious extends ActiveRecord
{
    public $start_date;
    public $end_date;
    public $count;

    public static function create(
        Client $client,
        Correspondent $correspondent,
        Date $date,
        Params $params,
        $filename = null
    ): Dubious
    {
        $dubious = new static();

        $dubious->id_cli = $client->id_cli;
        $dubious->mfo_cli = $client->mfo_cli;
        $dubious->inn_cli = $client->inn_cli;
        $dubious->account_cli = $client->account_cli;
        $dubious->name_cli = $client->name_cli;

        $dubious->mfo_cor = $correspondent->mfo_cor;
        $dubious->inn_cor = $correspondent->inn_cor;
        $dubious->account_cor = $correspondent->account_cor;
        $dubious->name_cor = $correspondent->name_cor;

        $dubious->date_msg = $date->date_msg;
        $dubious->date_doc = $date->date_doc;

        $dubious->pop = $params->pop;
        $dubious->doc_sum = $params->doc_sum;
        $dubious->ans_per = $params->ans_per;
        $dubious->currency = $params->currency;
        $dubious->criterion = $params->criterion;

        $dubious->file = $filename;

        return $dubious;
    }

    public function edit(Client $client, Correspondent $correspondent, Date $date, Params $params)
    {
        $this->id_cli = $client->id_cli;
        $this->mfo_cli = $client->mfo_cli;
        $this->inn_cli = $client->inn_cli;
        $this->account_cli = $client->account_cli;
        $this->name_cli = $client->name_cli;

        $this->mfo_cor = $correspondent->mfo_cor;
        $this->inn_cor = $correspondent->inn_cor;
        $this->account_cor = $correspondent->account_cor;
        $this->name_cor = $correspondent->name_cor;

        $this->date_msg = $date->date_msg;
        $this->date_doc = $date->date_doc;

        $this->pop = $params->pop;
        $this->doc_sum = $params->doc_sum;
        $this->ans_per = $params->ans_per;
        $this->currency = $params->currency;
        $this->criterion = $params->criterion;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dubious}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return DubiousHelper::attributeLabels();
    }
}
