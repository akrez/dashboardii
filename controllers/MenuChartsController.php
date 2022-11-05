<?php

namespace app\controllers;

use app\components\Crud;
use app\models\Menu;
use app\models\MenuChart;
use app\models\MenuChartSearch;
use Yii;

/**
 * MenuContentsController implements the CRUD actions for MenuContent model.
 */
class MenuChartsController extends Controller
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

    public function actionIndex($parent_id, $id = null)
    {
        $id = empty($id) ? null : intval($id);
        $post = Yii::$app->request->post();
        $state = Yii::$app->request->get('state', '');
        $updateCacheNeeded = null;
        //
        if ($id) {
            $model = Crud::findOrFail(MenuChart::getMenuChartBaseFindQuery($parent_id)->andWhere(['id' => $id]));
        } else {
            $model = null;
        }
        $newModel = new MenuChart();
        $searchModel = new MenuChartSearch();
        $parentModel = Crud::findOrFail(Menu::getMenuBaseFindQuery(null, $parent_id));
        //
        if (Yii::$app->request->isPost) {
            if ($state == 'create' && $newModel->load($post)) {
                $updateCacheNeeded = Crud::store($newModel, $post, [
                    'menu_id' => $parent_id,
                ]);
            } elseif ($state == 'update' && $model && $newModel->load($post)) {
                $updateCacheNeeded = Crud::store($model, $post, [
                    'menu_id' => $parent_id,
                ]);
            } elseif ($state == 'remove' && $model) {
                $updateCacheNeeded = Crud::softDelete($model);
            }
            if ($updateCacheNeeded) {
                $newModel = new MenuChart();
            }
        }
        //
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $parentModel);
        return $this->render('index', ['state' => $state] + compact('newModel', 'searchModel', 'model', 'dataProvider', 'parentModel'));
    }
}
