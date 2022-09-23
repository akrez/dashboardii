<?php

namespace app\controllers;

use app\components\Crud;
use app\components\Helper;
use app\models\Menu;
use app\models\MenuVisit;
use app\models\MenuVisitSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;

/**
 * MenuVisitsController implements the CRUD actions for MenuVisit model.
 */
class MenuVisitsController extends Controller
{
    public function behaviors()
    {
        return $this->defaultBehaviors([
            [
                'actions' => ['index'],
                'allow' => true,
                'verbs' => ['POST', 'GET'],
                'roles' => ['@'],
            ]
        ]);
    }

    /**
     * Lists all MenuVisit models.
     *
     * @return string
     */
    public function actionIndex($parent_id)
    {
        $parentModel = Crud::findOrFail(Menu::find()->andWhere(['id' => $parent_id]));

        $searchModel = new MenuVisitSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $parentModel);

        $columns = [
            'created_at:datetimefa',
            'menu.title',
            'submenu',
            'user.name',
            'user.email',
            // 'user_agent',
            [
                'value' => function ($model) {
                    $parseUserAgent = Helper::parseUserAgent($model->user_agent);
                    if (
                        $parseUserAgent['os']['name'] and
                        file_exists(Yii::getAlias('@webroot/img/os/' . $parseUserAgent['os']['name'] . '.svg'))
                    ) {
                        $url = Yii::getAlias('@web/img/os/' . $parseUserAgent['os']['name'] . '.svg');
                        return Html::img($url, ['width' => 30]);
                    }
                    return strval($parseUserAgent['os']['name']);
                },
                'format' => 'raw',
            ],
            [
                'value' => function ($model) {
                    $parseUserAgent = Helper::parseUserAgent($model->user_agent);
                    if (
                        $parseUserAgent['browser']['name'] and
                        file_exists(Yii::getAlias('@webroot/img/browser/' . $parseUserAgent['browser']['name'] . '.svg'))
                    ) {
                        $url = Yii::getAlias('@web/img/browser/' . $parseUserAgent['browser']['name'] . '.svg');
                        return Html::img($url, ['width' => 30]);
                    }
                    return strval($parseUserAgent['browser']['name']);
                },
                'format' => 'raw',
            ],
        ];

        return $this->render('/layouts/grid', [
            'title' => Yii::t('app', 'Menu Visits'),
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'pagination' => $dataProvider->getPagination(),
            'columns' => $columns,
        ]);
    }

    /**
     * Finds the MenuVisit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MenuVisit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuVisit::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
