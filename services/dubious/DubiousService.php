<?php

namespace app\services\dubious;


use app\entities\dubious\Client;
use app\entities\dubious\Correspondent;
use app\entities\dubious\Date;
use app\entities\dubious\Dubious;
use app\entities\dubious\Params;
use app\entities\ExcelTemplates;
use app\entities\user\User;
use app\forms\dubious\DubiousForm;
use app\helpers\dubious\DubiousHelper;
use app\repositories\dubious\DubiousRepository;
use app\services\TransactionManager;
use moonland\phpexcel\Excel;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class DubiousService
 * @package app\services\dubious
 * @property TransactionManager $transaction
 * @property DubiousRepository $repository
 */
class DubiousService
{
    private $repository;
    private $transaction;

    public function __construct(
        DubiousRepository $repository,
        TransactionManager $transactionManager)
    {
        $this->repository = $repository;
        $this->transaction = $transactionManager;
    }

    /**
     * @param DubiousForm $form
     * @return Dubious
     */

    public function create(DubiousForm $form)
    {

        VarDumper::dump($form);
        die;
        $dubious = Dubious::create();

        $this->repository->save($dubious);
        return $dubious;
    }

    public function edit($id, DubiousForm $form)
    {
        $client = new Client(
            $form->id_cli,
            $form->mfo_cli,
            $form->inn_cli,
            $form->account_cli,
            $form->name_cli
        );
        $correspondent = new Correspondent(
            $form->mfo_cor,
            $form->inn_cor,
            $form->account_cor,
            $form->name_cor
        );
        $date = new Date(
            $form->date_msg,
            $form->date_doc
        );
        $params = new Params(
            $form->pop,
            $form->ans_per,
            $form->currency,
            $form->criterion,
            $form->doc_sum
        );

        $dubious = $this->repository->get($id);

        $dubious->edit($client, $correspondent, $date, $params);

        $this->repository->save($dubious);
        return $dubious;
    }

    public function remove($id)
    {
        $dubious = $this->repository->get($id);
        $this->repository->remove($dubious);
    }

    /**
     * @param array $dubious
     * @param $filename
     * @throws \DomainException
     */
    public function load(array $dubious, $filename)
    {
        $errors = [];
        $success = [];
        try {
            foreach ($dubious as $item) {
                $errors[] = $item['errors'];
                $dubious = $this->repository->findByParams(
                    $item['correspondent']->account_cor,
                    $item['correspondent']->mfo_cor,
                    $item['client']->account_cli,
                    $item['client']->mfo_cli,
                    $item['params']->doc_sum,
                    $item['params']->criterion
                );

                if ($dubious) {
                    $errors[] = 'по р/с клиента '
                        . Html::a(
                            $dubious->account_cli,
                            Url::to(
                                [
                                    '/dubious',
                                    'DubiousSearch' => [
                                        'account_cli' => $dubious->account_cli
                                    ]
                                ])
                        ) . '</> по сумме документа <u>'
                        . Yii::$app->formatter->asCurrency(
                            $dubious->doc_sum,
                            DubiousHelper::currencyCodeToText($dubious->currency)
                        ) . '</u>';
                    continue;
                }

                $dubious = Dubious::create($item['client'],
                    $item['correspondent'],
                    $item['date'],
                    $item['params'],
                    $filename
                );
                // start transaction before save
                $this->transaction->wrap(function () use ($dubious) {
                    $this->repository->save($dubious);
                });
                $success[] = 'по р/с клиента ' . Html::a(
                        $dubious->account_cli,
                        Url::to(
                            [
                                '/dubious',
                                'DubiousSearch' => [
                                    'account_cli' => $dubious->account_cli
                                ]
                            ])
                    );

            }

            if (!empty($success)) {
                $data = Html::ul($success, ['encode' => false]);
                Yii::$app->session->setFlash('success', 'Данные успешно загружены! <br>' . $data);
            }

        } catch (\Exception $e) {
            throw new \DomainException($e->getMessage());
        }

        if (!empty($errors)) {
            $errors = Html::ul(array_filter($errors), ['encode' => false]);
            throw new \DomainException('Дублирование информации! <br>' . $errors);
        }


    }


    public function export($model)
    {
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
                    'value' => function ($model) {
                        return $model->user->name;
                    },
                    'filter' => ArrayHelper::map(User::find()->asArray()->all(), 'id', 'name')
                ],
                [
                    'attribute' => 'updated_by',
                    'value' => function ($model) {
                        return $model->user->name;
                    },
                    'filter' => ArrayHelper::map(User::find()->asArray()->all(), 'id', 'name')
                ],
            ],
            'headers' => [
                'created_at' => 'Date Created Content',
            ],
        ]);
    }
}