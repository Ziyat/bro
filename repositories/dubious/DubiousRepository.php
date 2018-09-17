<?php

namespace app\repositories\dubious;


use app\entities\dubious\Dubious;
use app\repositories\NotFoundException;
use Yii;
use RuntimeException;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class DubiousRepository
{
    public function get($id): Dubious
    {
        if (!$dubious = Dubious::findOne($id)) {
            throw new NotFoundException('Dubious is not found.');
        }
        return $dubious;
    }

    public function save(Dubious $dubious)
    {
        if ($dubious->save()) {
        } else {
            throw new RuntimeException('Saving error.');
        }
    }

    public function remove(Dubious $dubious)
    {
        if (!$dubious->delete()) {
            throw new RuntimeException('Removing error.');
        }
    }

    public function findCriterionByDateDocRange($startDate, $endDate): array
    {

        if (!$criterion = Dubious::find()
            ->select('criterion')
            ->distinct('criterion')
            ->andWhere(['>=', "date_doc", $startDate])
            ->andWhere(['< ', "date_doc", $endDate])
            ->all()) {
            throw new NotFoundException('Criterion is not found on the specified date');
        }
        return ArrayHelper::getColumn($criterion, 'criterion');
    }

    public function findUserIdsByDateDocRange($startDate, $endDate): array
    {
        if (!$userIds = Dubious::find()
            ->select('created_by')
            ->distinct('created_by')
            ->andWhere(['>=', "date_doc", $startDate])
            ->andWhere(['< ', "date_doc", $endDate])
            ->all()) {
            throw new NotFoundException('Users is not found on the specified date');
        }
        return ArrayHelper::getColumn($userIds, 'created_by');
    }

    /**
     * @param $account_cor
     * @param $mfo_cor
     * @param $account_cli
     * @param $mfo_cli
     * @param $date_msg
     * @param $date_doc
     * @param $doc_sum
     * @param $criterion
     * @return Dubious|null
     */
    public function findByParams(
        $account_cor,
        $mfo_cor,
        $account_cli,
        $mfo_cli,
        $doc_sum,
        $criterion
    ): ?Dubious
    {
        return $dubious = Dubious::findOne([
            'account_cor' => $account_cor,
            'mfo_cor' => $mfo_cor,
            'mfo_cli' => $mfo_cli,
            'doc_sum' => $doc_sum,
            'criterion' => $criterion,
        ]);
    }
}