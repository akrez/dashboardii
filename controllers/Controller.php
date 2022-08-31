<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\filters\auth\QueryParamAuth;
use yii\web\Controller as BaseController;

class Controller extends BaseController
{
    const TOKEN_PARAM = '_token';

    public function init()
    {
        parent::init();
        $this->layout = 'adminlte';
    }

    public function defaultBehaviors($accessRules = [])
    {
        return [
            'authenticator' => [
                'class' => QueryParamAuth::class,
                'optional' => ['*'],
                'tokenParam' => self::TOKEN_PARAM,
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => $accessRules,
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        Yii::$app->user->setReturnUrl(Url::current());
                        return $this->redirect(['/user/signin']);
                    }
                    throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
                }
            ],
        ];
    }
}
