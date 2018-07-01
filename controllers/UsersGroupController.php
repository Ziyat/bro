<?php

namespace app\controllers;

use app\forms\user\UsersGroupForm;
use app\services\user\UserService;
use Yii;
use app\entities\user\UsersGroup;
use app\entities\user\UsersGroupSearch;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersGroupController implements the CRUD actions for UsersGroup model.
 */
class UsersGroupController extends Controller
{
    private $service;

    public function __construct($id, $module, UserService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->is_admin;
                        }

                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UsersGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new UsersGroupForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $user = $this->service->createGroup($model);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsersGroup model.
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
     * Creates a new UsersGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new UsersGroupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                try {
                $user = $this->service->createGroup($form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing UsersGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new UsersGroupForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->editGroup($model->id,$form);
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * Deletes an existing UsersGroup model.
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
     * Finds the UsersGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UsersGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsersGroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
