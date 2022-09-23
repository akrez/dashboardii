<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\UserSignup;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class SeedController extends Controller
{
    public function actionAdminUsers()
    {
        $postedDatas = Yii::$app->params['adminSeedUsers'];
        foreach ($postedDatas as $postedDataKey => $postedData) {
            $model = new UserSignup();
            $model->load($postedData, '');
            if ($model->signup()) {
                echo ("\n" . $postedDataKey . ": " . 'Ok' . "\n");
            } else {
                echo ("\n"  . $postedDataKey . ": " . implode("\n", $model->getErrorSummary(true)) . "\n");
            }
        }
        return ExitCode::OK;
    }
}
