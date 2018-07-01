<?php
/**
 * Created by Madetec-Solution OK.
 * Developer: Mirkhanov Z.S.
 * Date: 19.06.2018
 */

namespace app\services\export;

use app\entities\user\User;
use app\entities\user\UsersGroup;
use app\repositories\dubious\DubiousRepository;
use app\forms\export\CentralBankForm;
use moonland\phpexcel\Excel;
use yii\helpers\VarDumper;

class ExportService
{
    private $dubious;
    private $usersGroup;

    public function __construct(DubiousRepository $dubious, UsersGroup $usersGroup)
    {
        $this->dubious = $dubious;
        $this->usersGroup = $usersGroup;
    }

    public function centralBankCreateFile(CentralBankForm $form)
    {
        if ($request = $this->prepareRequest($form->date)) {
            $dubious = $this->dubious->findByDateDoc($request);

            $dubiousSort = $this->sortByGroup($dubious);
//            VarDumper::dump($dubiousSort,10,true);die;
            $file = \Yii::createObject([
                'class' => 'codemix\excelexport\ExcelFile',
                'sheets' => [
                    'Report for Central bank' => [
                        'data' => $dubiousSort,
                        'titles' => [
                            'asfa'
                        ],
                    ]
                ]
            ]);
            return $file->send('demo.xlsx');


        }
    }

    private function prepareRequest($date)
    {
        $start = strtotime('first day of this month', strtotime($date));
        $end = strtotime('last day of this month', $start);
        return ['start' => $start, 'end' => $end] ?: false;
    }


    private function sortByGroup(array $dubious)
    {
        $groupSort = [];
        foreach ($dubious as $item) {
            $usersId[] = $item->created_by;
        }

        $users = User::find()->with('assignments')->where(['users.id' => $usersId])->all();

        foreach ($users as $k => $user) {
            foreach ($dubious as $item) {

                if ($item->created_by == $user->id && count($user->assignments) > 0) {
                    $criterion = explode('.', $item->criterion)[1];
                    $currentKey = $groupSort[$k]["по $criterion критерию п.48, ПВК - 2886"];
                    if (isset($currentKey)) {
                        $groupSort[$k]["по $criterion критерию п.48, ПВК - 2886"]++;
                    } else {
                        $groupSort[$k]["по $criterion критерию п.48, ПВК - 2886"] = 1;
                    }
                }

            }


        }


        return $groupSort;
    }
}