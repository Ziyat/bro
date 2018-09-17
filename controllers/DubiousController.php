<?php

namespace app\controllers;

use app\entities\dubious\Dubious;
use app\entities\dubious\DubiousSearch;
use app\entities\user\UsersAssignment;
use app\forms\dubious\DubiousForm;
use app\forms\LogForm;
use app\forms\UploadForm;
use app\handlers\ExcelHandler;
use app\helpers\dubious\DubiousHelper;
use app\repositories\NotFoundException;
use app\services\dubious\DubiousService;
use app\services\LogService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * DubiousController implements the CRUD actions for User model.
 *
 */
class DubiousController extends Controller
{
    private $service;
    private $logService;

    public function __construct($id, $module, DubiousService $service, LogService $logService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->logService = $logService;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            /*'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->is_admin;
                        }

                    ],
                ],
            ],*/
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex()
    {
        $searchModel = new DubiousSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $form = new UploadForm();
        try {
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $handler = new ExcelHandler();
                $dubious = $handler->parsing($form->file);
                $this->service->load($dubious, $form->file);
                return $this->redirect(['index']);
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if ($message != '') {
                Yii::$app->session->setFlash('info', $message);
            }
        } catch (\Throwable $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $form
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new Dubious model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if (Yii::$app->request->post()) {
            $form = new DubiousForm(null, Yii::$app->request->post());
            $form->load(Yii::$app->request->post());
            $form->validate();
        }
//        if ($form->load(Yii::$app->request->post(),'') && $form->validate()) {
//            try {
//                $dubious = $this->service->create($form);
//                $this->logger();
//                return $this->redirect(['view', 'id' => $dubious->id]);
//            } catch (\DomainException $e) {
//                Yii::$app->errorHandler->logException($e);
//                Yii::$app->session->setFlash('error', $e->getMessage());
//            }
//        }

        return $this->render('create');
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $dubious = $this->findModel($id);
        $form = new DubiousForm($dubious);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $dubious = $this->service->edit($dubious->id, $form);
                $this->logger();
                return $this->redirect(['view', 'id' => $dubious->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'dubious' => $dubious,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $redirectId = DubiousHelper::getPreviousAndNextId($id, Yii::$app->user->identity->id);
        try {
            $this->service->remove($id);
            $this->logger();
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $redirectId['next'] ?: $redirectId['prev']]);
    }

    /**
     * @return mixed
     */
    public function actionGroupRemove()
    {
        $users = DubiousHelper::getUsersInGroup(Yii::$app->user->identity, true);

        $dataProvider = new ActiveDataProvider([
            'query' => Dubious::find()->where(['created_by' => $users])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        if ($ids = Yii::$app->request->post()) {
            if (isset($ids['Dubious'])) {
                foreach ($ids['Dubious'] as $id) {
                    try {
                        $this->service->remove($id);
                    } catch (\DomainException $e) {
                        Yii::$app->session->setFlash('error', $e->getMessage());
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', 'Вы не отметили запись');
            }


        }
        return $this->render('remove', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionImport()
    {
        $form = new UploadForm();
        if ($form->load(Yii::$app->request->post())) {
            $form->file = UploadedFile::getInstance($form, 'file');
            $filePath = $form->uploadFile($form->file);
            $handler = new ExcelHandler();
            $handler->importExcel($filePath);
            try {
                $filePath = $form->uploadFile($form->file);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->render('import', [
                    'model' => $form,
                ]);
            }

            try {
                $this->service->importExcel($filePath);

//                $this->logger();

                return $this->redirect(['index']);
            } catch (NotFoundException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('import', [
            'model' => $form,
        ]);
    }

    public function actionExport()
    {
        $dubious = new Dubious();
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $start_date = strtotime($post['Dubious']['start_date']);
            $end_date = strtotime($post['Dubious']['end_date']);

            if (!$start_date && !$end_date) {
                Yii::$app->session->setFlash('error', 'Выберите дату');
                return $this->render('export', [
                    'model' => $dubious
                ]);
            }
            if (Yii::$app->user->identity->is_admin) {
                $this->service->export(Dubious::find()
                    ->where($this->prepareRequest($start_date, $end_date))
                    ->all());

            } else {
                $this->service->export(Dubious::find()
                    ->where(['created_by' => DubiousHelper::getUsersInGroup(Yii::$app->user->identity, new UsersAssignment())])
                    ->andWhere($this->prepareRequest($start_date, $end_date))
                    ->all());
            }

        }
        return $this->render('export', [
            'model' => $dubious
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dubious the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dubious::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function logger()
    {
        $logForm = new LogForm();
        $logForm->action = $this->action->controller->id . '/' . $this->action->id;
        $logForm->user_id = Yii::$app->user->identity->getId();
        $this->logService->create($logForm);
    }

    protected function prepareRequest($startDate, $endDate)
    {
        $startDate = Date('m-d-y', $startDate);
        $endDate = Date('m-d-y', $endDate);
        $sql = "STR_TO_DATE(date_msg, '%m-%d-%y') >= STR_TO_DATE('$startDate', '%m-%d-%y') AND STR_TO_DATE(date_msg, '%m-%d-%y') <= STR_TO_DATE('$endDate', '%m-%d-%y')";
        return $sql;
    }
}
