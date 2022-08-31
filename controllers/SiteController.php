<?php

namespace app\controllers;

class SiteController extends Controller
{
    public function init()
    {
        parent::init();
        $this->layout = 'site';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return $this->defaultBehaviors([
            [
                'actions' => ['error', 'index', 'captcha'],
                'allow' => true,
                'verbs' => ['POST', 'GET'],
                'roles' => ['?', '@'],
            ],
        ]);
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
