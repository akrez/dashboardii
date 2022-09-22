<?php

namespace app\controllers;

use app\components\Crud;
use app\models\Menu;
use app\models\MenuContentImport;
use app\models\MenuContentSearch;
use Yii;

/**
 * MenuContentsController implements the CRUD actions for MenuContent model.
 */
class MenuContentsController extends Controller
{
    public function init()
    {
        parent::init();
    }

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
        $model = null;
        $newModel = new MenuContentImport();
        $searchModel = new MenuContentSearch();
        $parentModel = Crud::findOrFail(Menu::find()->andWhere(['id' => $parent_id]));
        //
        if (Yii::$app->request->isPost) {
            if ($state == 'import' and $newModel->load($post) and $newModel->import($parentModel)) {
                $updateCacheNeeded = true;
            }
            if ($updateCacheNeeded) {
                $newModel = new MenuContentImport();
            }
        }
        //
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $parentModel);
        return $this->render('index', ['state' => $state] + compact('newModel', 'searchModel', 'model', 'dataProvider', 'parentModel'));
    }
}
