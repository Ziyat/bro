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
use app\repositories\user\UserRepository;
use moonland\phpexcel\Excel;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class ExportService
{
    private $dubious;
    private $users;

    public function __construct(DubiousRepository $dubious, UserRepository $users)
    {
        $this->dubious = $dubious;
        $this->users = $users;
    }

    public function centralBankReport(CentralBankForm $form)
    {
        $criterion = $this->dubious
            ->findCriterionByDateDocRange(
                $form->startDate,
                $form->endDate
            );
        $userIds = $this->dubious
            ->findUserIdsByDateDocRange(
                $form->startDate,
                $form->endDate
            );

        $users = $this->users->getByIds($userIds);

        foreach ($users as $user){
            /**
             * @var User $user
             */
            $user->groups;
        }
        return true;
    }
}