<?php

namespace app\controllers;

use app\forms\excel\TemplatesForm;
use app\services\excel\ExcelService;
use Yii;
use app\entities\excel\ExcelTemplates;
use app\entities\excel\ExcelTemplatesSearch;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExcelTemplatesController implements the CRUD actions for ExcelTemplates model.
 */
class ExcelTemplatesController extends Controller
{

    public $service;

    public function __construct($id, $module, ExcelService $service , array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ExcelTemplates models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExcelTemplatesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ExcelTemplates model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ExcelTemplates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new TemplatesForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $model = $this->service->create($form);
                return $this->redirect(['view', 'id' => $model->id]);
            }catch (\Exception $e){
                Yii::$app->session->setFlash('error',$e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing ExcelTemplates model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ExcelTemplates model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ExcelTemplates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExcelTemplates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExcelTemplates::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
