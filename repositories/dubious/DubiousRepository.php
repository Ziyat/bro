<?php

namespace app\repositories\dubious;


use app\entities\dubious\Dubious;
use app\repositories\NotFoundException;
use Yii;
use RuntimeException;
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
        $transaction = Yii::$app->db->beginTransaction();
        if ($dubious->save()) {
            $transaction->commit();
        } else {
            $transaction->rollback();
            throw new RuntimeException('Saving error.');
        }
    }

    public function remove(Dubious $dubious)
    {
        if (!$dubious->delete()) {
            throw new RuntimeException('Removing error.');
        }
    }

    public function findByDateDoc(array $date): array
    {

        if (!$dubious = Dubious::find()
            ->andWhere("created_at >= ".$date['start'])
            ->andWhere("created_at < ".$date['end'])
            ->all()) {
            throw new NotFoundException('Dubious is not found on the specified date');
        }
        return $dubious;
    }
}