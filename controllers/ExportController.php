<?php

namespace app\controllers;


use app\services\export\ExportService;
use app\forms\export\CentralBankForm;
use app\forms\LogForm;
use app\services\LogService;
use yii\helpers\VarDumper;
use \yii\web\Controller;
use Yii;


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

    public function actionIndex()
    {

        $form = new CentralBankForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try
            {
                $this->service->centralBankCreateFile($form);
            }catch (\Exception $e){
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }


//        $this->logger();
        return $this->render('index', [
            'form' => $form
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