<?php

namespace app\controllers;

use app\commands\SeedController;
use Yii;
use yii\console\controllers\MigrateController;
use yii\web\UnauthorizedHttpException;

class HooksController extends Controller
{
    public function beforeAction($action)
    {
        if (!defined('STDIN'))  define('STDIN',  fopen('php://stdin',  'rb'));
        if (!defined('STDOUT')) define('STDOUT', fopen('php://stdout', 'wb'));
        if (!defined('STDERR')) define('STDERR', fopen('php://stderr', 'wb'));

        $authHeader = Yii::$app->request->getHeaders()->get('Authorization');
        if (!$this->isAuth($authHeader)) {
            throw new UnauthorizedHttpException('Your request was made with invalid credentials.');
        }

        Yii::$app->controller->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return $this->defaultBehaviors([
            [
                'actions' => ['migrate', 'seed'],
                'allow' => true,
                'verbs' => ['POST'],
                'roles' => ['@', '?'],
            ],
        ]);
    }

    public function isAuth($authHeader)
    {
        if (
            $authHeader !== null and
            preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches) and
            $matches[1] === Yii::$app->params['hooksAuthorizationToken']
        ) {
            return true;
        }
        return false;
    }

    public function actionMigrate($param)
    {
        $consoleController = new MigrateController(Yii::$app->controller->id, Yii::$app);
        $consoleController->interactive = false;
        $consoleController->runAction($param);
        $response = ob_get_clean();
        $response = str_replace(">", "\n >", $response);

        die($response);
    }

    public function actionSeed($param)
    {
        $consoleController = new SeedController(Yii::$app->controller->id, Yii::$app);
        $consoleController->interactive = false;
        $consoleController->runAction($param);
        $response = ob_get_clean();
        $response = str_replace(">", "\n >", $response);

        die($response);
    }
}
