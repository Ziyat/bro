<?php

namespace app\controllers;


use app\entities\Export\CentralBankSearch;
use app\forms\LogForm;
use app\services\export\ExportService;
use app\services\LogService;
use Yii;
use yii\web\Controller;


class ExportController extends Controller
{
    private $logService;
    private $service;

    public function __construct($id, $module, ExportService $service, LogService $logService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->logService = $logService;
    }

    /**
     * @return string
     * @throws \Exception
     */

    public function actionCentralBank()
    {
        $searchModel = new CentralBankSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $this->logger();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }


    protected function logger()
    {
        $logForm = new LogForm();
        $logForm->action = $this->action->controller->id . '/' . $this->action->id;
        $logForm->user_id = Yii::$app->user->identity->getId();
        $this->logService->create($logForm);
    }

}