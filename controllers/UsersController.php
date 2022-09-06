<?php

namespace app\controllers;

use app\models\User;
use app\models\UserSignin;
use app\models\UserSignup;
use Throwable;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class UsersController extends Controller
{
    public function init()
    {
        parent::init();
        $this->layout = 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return $this->defaultBehaviors([
            [
                'actions' => ['signin', 'signup',],
                'allow' => true,
                'verbs' => ['POST', 'GET'],
                'roles' => ['?'],
            ],
            [
                'actions' => ['signout'],
                'allow' => true,
                'verbs' => ['POST'],
                'roles' => ['@'],
            ],
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionSignin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new UserSignin();
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->getUser()) {
            User::login($model->getUser(), $model->remember_me ? 3600 * 24 * 30 : 0);
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('signin', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        User::deleteUnverifiedTimeoutedBlog();

        $model = new UserSignup();
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->getUser()) {
            User::login($model->getUser());
            return $this->goBack();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionSignout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['/site/index']);
    }
}
