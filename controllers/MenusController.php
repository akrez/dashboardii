<?php

namespace app\controllers;

use app\components\Crud;
use app\models\Menu;
use app\models\MenuSearch;
use Yii;

class MenusController extends Controller
{
    public function init()
    {
        parent::init();
        $this->layout = 'site';
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

    public function actionIndex($id = null)
    {
        $id = empty($id) ? null : intval($id);
        $post = Yii::$app->request->post();
        $state = Yii::$app->request->get('state', '');
        $updateCacheNeeded = null;
        $parentModel = null;
        //
        if ($id) {
            $model = Crud::findOrFail(Menu::find()->andWhere(['id' => $id]));
        } else {
            $model = null;
        }
        $newModel = new Menu();
        $searchModel = new MenuSearch();
        //
        if (Yii::$app->request->isPost) {
            if ($state == 'create' && $newModel->load($post)) {
                $updateCacheNeeded = Crud::store($newModel, $post, [
                    'user_id' => Yii::$app->user->getId(),
                ]);
            } elseif ($state == 'update' && $model && $newModel->load($post)) {
                $updateCacheNeeded = Crud::store($model, $post, [
                    'user_id' => Yii::$app->user->getId(),
                ]);
            }
            if ($updateCacheNeeded) {
                $newModel = new Menu();
            }
        }
        //
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', ['state' => $state] + compact('newModel', 'searchModel', 'model', 'dataProvider', 'parentModel'));
    }
}
