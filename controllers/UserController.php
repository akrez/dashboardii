<?php

namespace app\controllers;

use app\models\UserSignin;
use Yii;
use yii\web\Response;

class UserController extends Controller
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
                'actions' => ['signin'],
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
        if ($model->load(Yii::$app->request->post()) && $model->signin()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('signin', [
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
