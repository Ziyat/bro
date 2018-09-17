<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace app\handlers;

use app\entities\dubious\Client;
use app\entities\dubious\Correspondent;
use app\entities\dubious\Date;
use app\entities\dubious\Params;
use moonland\phpexcel\Excel;
use yii\helpers\VarDumper;

/**
 * Class ExcelHandler
 * @package app\handlers
 * @property IdentifyDataHandler $dataHandler;
 */
class ExcelHandler
{
    public $dataHandler;

    public function __construct()
    {
        $this->dataHandler = new IdentifyDataHandler;
    }

    public function parsing($filename)
    {
        $data = $this->parseExcel(\Yii::getAlias('@upload') . '/' . $filename);
        $data = $this->handleLevelOne($data);
        $data = $this->identifyData($data);
        $data = $this->handleLevelTwo($data);
        $data = $this->handleLevelThree($data);

        return $data;
    }


    public function identifyData($array)
    {
        $result = [
            'account_cli' => 'F',
            'name_cli' => 'G',
            'inn_cli' => 'E',
            'account_cor' => 'I',
            'name_cor' => 'K',
            'inn_cor' => 'J',
            'date_msg' => 'C',
            'date_doc' => 'O',
            'criterion' => 'P',
            'ans_per' => 'N',
            'pop' => 'Q',
            'doc_sum' => 'L',
            'mfo_cli' => 'D',
            'mfo_cor' => 'H',
        ];

        $mfo_cli = false;
        $hei = null;
        foreach ($array as $pk => $data) {

            foreach ($data as $k => $value) {
                if ($this->dataHandler->isClientAccount($value)) {
                    $result['account_cli'] = $k;
                    $hei[] = $pk;

                };
                if ($this->dataHandler->isClientName($value)) $result['name_cli'] = $k;
                if ($this->dataHandler->isClientInn($value)) $result['inn_cli'] = $k;

                if ($this->dataHandler->isCorAccount($value)) $result['account_cor'] = $k;
                if ($this->dataHandler->isCorName($value)) $result['name_cor'] = $k;
                if ($this->dataHandler->isCorInn($value)) $result['inn_cor'] = $k;

                if ($this->dataHandler->isDateMsg($value)) $result['date_msg'] = $k;
                if ($this->dataHandler->isDateDocument($value)) $result['date_doc'] = $k;

                if ($this->dataHandler->isCriterion($value)) $result['criterion'] = $k;

                if ($this->dataHandler->isAnswerPerformer($value)) $result['ans_per'] = $k;

                if ($this->dataHandler->isPurposeOfPayment($value)) $result['pop'] = $k;

                if ($this->dataHandler->isDocumentSum($value)) $result['doc_sum'] = $k;

                if ($this->dataHandler->isMfo($value)) {
                    if (!$mfo_cli) {
                        $result['mfo_cli'] = $k;
                        $mfo_cli = true;
                    } else {
                        $result['mfo_cor'] = $k;
                    }
                }
            }
        }

        if (count($hei) > 0) {
            foreach ($hei as $key) {
                unset($array[$key]);
            }
        }

        $array = array_values($array);

        foreach ($array as $k => $data) {
            $keys = array_keys($data);
            $actualKeys = array_values($result);
            foreach ($actualKeys as $key) {
                if(empty($data[$key]))
                {
                    $data[$key] = null;
                    $array[$k] = $data;
                    continue;
                }
            }
        }
        $array['template'] = $result;
        return $array;
    }

    protected function parseExcel($filePath)
    {
        $data = Excel::widget([
            'mode' => 'import',
            'fileName' => $filePath,
            'setFirstRecordAsKeys' => false,
            'setIndexSheetByName' => false
        ]);
        if ($this->getArrayLevel($data) == 3) {
            $data = array_shift($data);
        }
        return $data;

    }

    protected function getArrayLevel($arr)
    {
        $lvl = 0;
        foreach ($arr as $val) {
            if (is_array($val)) {
                $lvl_arr = $this->getArrayLevel($val);
                $lvl = ($lvl > $lvl_arr) ? $lvl : $lvl_arr;
            }
        }
        return ++$lvl;
    }

    protected function handleLevelOne(array $data)
    {
        foreach ($data as $k => $d) {
            $data[$k] = array_filter($d, function ($element) {
                return !empty($element);
            });
        }
        $data = array_filter($data, function ($element) {
            return !empty($element);
        });

        return $data;
    }

    protected function handleLevelTwo(array $data)
    {

        $template = $data['template'];
        unset($data['template']);

        foreach ($data as $k => $values) {
            $accountClient = $values[$template['account_cli']];
            $accountCor = $values[$template['account_cor']];
            if($accountClient == '' || $accountClient == null)
            {
               continue;
            }


            foreach ($values as $kk => $t) {
                $t = trim($t);
                $t = preg_replace("/(\s){2,}/", ' ', $t);
                if ($kk == $template['doc_sum']) {
                    $t = str_replace(".00", '', $t);
                    $t = str_replace(",", '', $t);
                    preg_match('/^([0-9]+.[0-9][0-9])/', $t, $matches);
                    if ($matches) {
                        $t = $matches[0];
                    } else {
                        $t = preg_replace("/\D/", '', $t);
                    }
                }
                if ($template['criterion'] && $kk == $template['criterion']) {
                    $t = str_replace(",", '.', $t);
                }
                $values[$kk] = $t;
            }


            if (!$values[$template['date_msg']] = $this->checkDate($values[$template['date_msg']])) {
                $values[$template['date_msg']] = strtotime(date('Y-m-d'));
            };

            if (!$values[$template['date_doc']] = $this->checkDate($values[$template['date_doc']])) {
                $values[$template['date_doc']] = strtotime(date('Y-m-d'));
            };

            if ($this->dataHandler->isBankAccount($accountClient)) {
                $values['id_cli'] = substr($accountClient, 9, 8);
                $values['currency'] = substr($accountClient, 5, 3);
            }


//            $errors[] = $this->checkCurrency($account, $values['M'], $values['A'])
//                ?? $this->checkCurrency($accountСor, $values['M'], $values['A']);
//
//            $errors[] = $this->checkClientId($account, $values['B'], $values['A']);

//            if (empty($values['F'])) continue;


            $date = new Date();
            $client = new Client();
            $params = new Params();
            $correspondent = new Correspondent();

            $client->id_cli = $values['id_cli'];
            $params->currency = $values['currency'];

            foreach ($values as $key => $val) {
                switch ($key) {
                    case $template['date_msg']:
                        $date->date_msg = $val;
                        break;
                    case $template['mfo_cli']:
                        $client->mfo_cli = $val;
                        break;
                    case $template['inn_cli']:
                        $client->inn_cli = $val;
                        break;
                    case $template['account_cli']:
                        $client->account_cli = $val;
                        break;
                    case $template['name_cli']:
                        $client->name_cli = $val;
                        break;
                    case $template['mfo_cor']:
                        $correspondent->mfo_cor = $val;
                        break;
                    case $template['account_cor']:
                        $correspondent->account_cor = $val;
                        break;
                    case $template['inn_cor']:
                        $correspondent->inn_cor = $val;
                        break;
                    case $template['name_cor']:
                        $correspondent->name_cor = $val;
                        break;
                    case $template['doc_sum']:
                        $params->doc_sum = floatval($val);
                        break;
                    case $template['pop']:
                        $params->pop = $val;
                        break;
                    case $template['date_doc']:
                        $date->date_doc = $val;
                        break;
                    case $template['criterion']:
                        $params->criterion = trim($val, '.');
                        break;
                    case $template['ans_per']:
                        $params->ans_per = $val;
                        break;
                }

            }

            $result[] = [
                'client' => $client,
                'correspondent' => $correspondent,
                'params' => $params,
                'date' => $date,
                'errors' => null
            ];

        }

//        $errors = array_filter($errors);
//        if (!empty($errors)) {
//            $errorsStr = implode('<br />', $errors);
//            $result['errors'] = $errorsStr;
//        }
        return $result;
    }

    protected function handleLevelThree(array $data)
    {
        return array_intersect_key($data, array_unique(array_map('serialize', $data)));
    }


    private function checkCurrency($account, $currency, $line)
    {
        $result = null;
        if (substr($account, 5, 3) != $currency) {
            $result = 'В п/п [ ' . $line . ' ] Р/С ' . $account . ' не совпадает с Валютой ' . $currency;
        };

        return $result;
    }

    private function checkClientId($account, $clientId, $line)
    {
        $result = null;
        if (substr($account, 9, 8) != $clientId) {
            $result = 'В п/п [ ' . $line . ' ] Р/С ' . $account . ' не совпадает c ID клиента ' . $clientId;
        };

        return $result;
    }


    private function checkDate($strDate)
    {
        $strDate = str_replace([".", "/", "-", " "], '-', $strDate);
        $formats = [
            'd-m-Y',
            'd-m-y',
            'm-d-Y',
            'm-d-y',
            'Y-d-m',
            'Y-m-d',
            'y-m-d',
            'y-d-m',
        ];

        foreach ($formats as $format) {
            $dateTime = $this->validateDate($strDate, $format);
            if ($dateTime) {
                $strTime = strtotime($dateTime->format('Y-m-d'));
                return $strTime < time() ? $strTime : false;
            }
        }
        return false;

    }

    /**
     * @param $date
     * @param string $format
     * @return bool|\DateTime
     */

    private function validateDate($date, $format = 'Y-m-d')
    {
        $current = \DateTime::createFromFormat($format, $date);
        return ($current && $current->format($format) === $date) ? $current : false;
    }
}
