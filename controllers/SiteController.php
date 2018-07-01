<?php

namespace app\controllers;

use app\entities\dubious\Dubious;
use app\entities\user\User;
use app\entities\user\UsersGroup;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\forms\LoginForm;
use app\forms\ContactForm;

class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index',[
            'dubious' => Dubious::find()->count(),
            'users' => User::find()->count(),
            'groups' => UsersGroup::find()->count(),
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
}
