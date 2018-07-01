<?php
namespace app\controllers;

use app\forms\LogForm;
use app\forms\LoginForm;
use app\services\LogService;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

class AuthController extends Controller
{
    public $logService;

    public function __construct($id, $module,LogService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->logService = $service;
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'main-login';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->logger();
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $this->logger();
        Yii::$app->user->logout();

        return $this->goHome();
    }


    protected function logger(){
        $logForm = new LogForm();
        $logForm->action = $this->action->controller->id .'/'. $this->action->id;
        $logForm->user_id = Yii::$app->user->identity->getId();
        $this->logService->create($logForm);
    }
}