<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace app\forms\dubious;


use app\entities\dubious\Client;
use yii\base\Model;

class ClientForm extends Model
{
    public $id_cli;
    public $mfo_cli;
    public $inn_cli;
    public $account_cli;
    public $name_cli;

    private $_client;

    public function __construct(Client $client = null, array $config = [])
    {
        if ($client) {
            $this->id_cli = $client->id_cli;
            $this->mfo_cli = $client->inn_cli;
            $this->account_cli = $client->account_cli;
            $this->name_cli = $client->name_cli;

            $this->_client = $client;
        }
        parent::__construct($config);
    }


    public function rules()
    {
        return [
            ['id_cli','required'],
            [['id_cli', 'mfo_cli', 'name_cli'], 'string', 'max' => 255],
            [['inn_cli', 'account_cli'], 'integer'],
        ];
    }

}