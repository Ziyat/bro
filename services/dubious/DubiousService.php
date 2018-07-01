<?php

namespace app\services\dubious;


use app\entities\dubious\Dubious;
use app\entities\ExcelTemplates;
use app\entities\user\User;
use app\forms\dubious\DubiousForm;
use app\repositories\dubious\DubiousRepository;
use app\entities\dubious\Client;
use app\entities\dubious\Correspondent;
use app\entities\dubious\Date;
use app\entities\dubious\Params;
use app\repositories\NotFoundException;
use moonland\phpexcel\Excel;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\VarDumper;

class DubiousService
{
    private $repository;

    public function __construct(DubiousRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param DubiousForm $form
     * @return Dubious
     */

    public function create(DubiousForm $form)
    {
        $dubious = Dubious::create();

        $this->repository->save($dubious);
        return $dubious;
    }

    public function edit($id, DubiousForm $form)
    {
        $client = new Client($form->id_cli,$form->mfo_cli,$form->inn_cli,$form->account_cli,$form->name_cli);
        $correspondent = new Correspondent($form->mfo_cor, $form->inn_cor, $form->account_cor, $form->name_cor);
        $date = new Date($form->date_msg, $form->date_doc);
        $params = new Params($form->pop, $form->ans_per, $form->currency, $form->criterion, $form->doc_sum);
        $dubious = $this->repository->get($id);
        $dubious->edit($client,$correspondent,$date,$params);

        $this->repository->save($dubious);
        return $dubious;
    }

    public function remove($id)
    {
        $dubious = $this->repository->get($id);
        $this->repository->remove($dubious);
    }


    public function importExcel($filePath)
    {
        $data = $this->parseExcel($filePath);


        $result = [];
        foreach ($data as $k => $values) {
            if(($values['A'] == null) || (strtolower(trim($values['A'])) == 'п/п')){
                continue;
            }

            foreach ($values as $key => $val){

                switch ($key){
                    case 'A':
                        break;
                    case 'B':
                        $client['id_cli'] = $val;
                        break;
                    case 'C':
                        $date['date_msg'] = $val;
                        break;
                    case 'D':
                        $client['mfo_cli'] = $val;
                        break;
                    case 'E':
                        $client['inn_cli'] = $val;
                        break;
                    case 'F':
                        $client['account_cli'] = $val;
                        break;
                    case 'G':
                        $client['name_cli'] = $val;
                        break;
                    case 'H':
                        $correspondent['mfo_cor'] = $val;
                        break;
                    case 'I':
                        $correspondent['account_cor'] = $val;
                        break;
                    case 'J':
                        $correspondent['inn_cor'] = $val;
                        break;
                    case 'K':
                        $correspondent['name_cor'] = $val;
                        break;
                    case 'L':
                        $params['doc_sum'] = $val;
                        break;
                    case 'M':
                        $params['currency'] = $val;
                        break;
                    case 'N':
                        $params['pop'] = $val;
                        break;
                    case 'O':
                        $date['date_doc'] = $val;
                        break;
                    case 'P':
                        $params['criterion'] = $val;
                        break;
                    case 'Q':
                        $params['ans_per'] = $val;
                        break;
                }
            }



            if(!$date['date_doc'] || !$date['date_msg'] || !$params['doc_sum'] ){
                continue;
            }

            try{
                $dateObj = new Date(
                    $date['date_msg'],
                    $date['date_doc']
                );
                $clientObj = new Client(
                    $client['id_cli'],
                    $client['mfo_cli'],
                    $client['inn_cli'],
                    $client['account_cli'],
                    $client['name_cli']
                );
                $paramsObj = new Params(
                    $params['pop'],
                    $params['ans_per'],
                    $params['currency'],
                    $params['criterion'],
                    $params['doc_sum']
                );
                $correspondentObj = new Correspondent(
                    $correspondent['mfo_cor'],
                    $correspondent['inn_cor'],
                    $correspondent['account_cor'],
                    $correspondent['name_cor']
                );
            } catch(\ErrorException $e){
                unlink($filePath);
                $temp = '<ul>'
                            .'<li>A = п/п</li>'
                            .'<li>B = ID клиента</li>'
                            .'<li>C = Дата сообщения</li>'
                            .'<li>D = МФО клиента</li>'
                            .'<li>E = ИНН клиента</li>'
                            .'<li>F = Счет клиента</li>'
                            .'<li>G = Наименование клиента</li>'
                            .'<li>H = МФО корреспондента</li>'
                            .'<li>I = ИНН корреспондента</li>'
                            .'<li>J = Счет корреспондента</li>'
                            .'<li>K = Наименование корреспондента</li>'
                            .'<li>L = Сумма документа</li>'
                            .'<li>M = Валюта</li>'
                            .'<li>N = Назначение платежа</li>'
                            .'<li>O = Дата проводки</li>'
                            .'<li>P = Критерий</li>'
                            .'<li>Q = Ответ.исполнитель</li>'
                        .'</ul>';
                throw new NotFoundException('Ошибка шаблона, проверьте соответствие '.$temp);
            }





            $dubious = Dubious::create($clientObj,$correspondentObj,$dateObj,$paramsObj);

            $this->repository->save($dubious);
            unset($date);
            unset($client);
            unset($params);
            unset($dubious);
            unset($correspondent);
        }
    }

    public function export($model){
        return Excel::export([
            'models' => $model,
            'columns' => [
                'id',
                'id_cli',
                'mfo_cli',
                'inn_cli',
                'account_cli',
                'name_cli',
                'mfo_cor',
                'inn_cor',
                'account_cor',
                'name_cor',
                'date_msg',
                'date_doc',
                'doc_sum',
                'pop',
                'ans_per',
                'currency',
                'criterion',
                'created_at:datetime',
                'updated_at:datetime',
                [
                    'attribute' => 'created_by',
                    'value' => function($model){
                        return $model->user->name;
                    },
                    'filter'=> ArrayHelper::map(User::find()->asArray()->all(),'id','name')
                ],
                [
                    'attribute' => 'updated_by',
                    'value' => function($model){
                        return $model->user->name;
                    },
                    'filter'=> ArrayHelper::map(User::find()->asArray()->all(),'id','name')
                ],
            ],
            'headers' => [
                'created_at' => 'Date Created Content',
            ],
        ]);
    }



    protected function parseExcel($filePath)
    {
        $data = Excel::widget([
            'mode' => 'import',
            'fileName' => $filePath,
            'setFirstRecordAsKeys' => false,
            'setIndexSheetByName' => false,
        ]);

        if(isset($data[0])){
            return  array_shift($data)?: false;
        }

        return $data;

    }

    protected function dateReformat($date)
    {

        $exp = explode('-',$date);
        if(count($exp) > 1)
        {
            $newDate=[
                $exp[0],
                $exp[1],
                $exp[2],
            ];
            $newDate = implode('.',$newDate);
        }else{
            $newDate = '';
        }
        return $newDate;
    }
}