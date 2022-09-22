<?php

namespace app\controllers;

use app\components\Crud;
use app\components\Helper;
use app\models\Menu;
use app\models\MenuChart;
use app\models\MenuContent;
use app\models\MenuVisit;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class ChartsController extends Controller
{
    public function init()
    {
        parent::init();
    }

    public function behaviors()
    {
        return $this->defaultBehaviors([
            [
                'actions' => ['index', 'menu'],
                'allow' => true,
                'verbs' => ['POST', 'GET'],
                'roles' => ['@'],
            ],
            [
                'actions' => ['view'],
                'allow' => true,
                'verbs' => ['POST', 'GET'],
                'roles' => ['@', '?'],
            ],
        ]);
    }

    public function actionMenu($id)
    {
        $submenu = Yii::$app->request->get('submenu');

        $userid = intval(Yii::$app->user->getId());
        $id = intval($id);

        $menu = Crud::findOrFail(Menu::getMenuBaseFindQuery($userid, $id));

        return $this->menu($menu, $submenu, [
            'hash' => Helper::encode([
                'id' => $menu->id,
                'submenu' => $submenu,
            ], Helper::getSecretKey())
        ]);
    }

    public function actionView($hash)
    {
        $decodedData = Helper::decode($hash, Helper::getSecretKey());
        if (empty($decodedData)) {
            throw new NotFoundHttpException();
        }

        $id = intval($decodedData['id']);

        $menu = Crud::findOrFail(Menu::getMenuBaseFindQuery(null, $id));

        return $this->menu($menu, $decodedData['submenu']);
    }

    private function menu($menu, ?string $submenu, $params = [])
    {
        MenuVisit::create($menu->id, $submenu);

        $id = $menu->id;

        $menuCharts = MenuChart::find()
            ->andWhere(['menu_id' => $id])
            ->andWhere(['deleted_at' => null])
            ->orderBy(['priority' => SORT_DESC])
            ->all();

        $charts = [];
        foreach ($menuCharts as $menuChart) {
            $charts[] = static::getChartInfo($menuChart, $submenu);
        }

        $gridDataProvider = null;
        if ($menu->grid_where_like) {
            $gridQuery = MenuContent::getMenuContentBaseFindQuery($id);
            if ('submenu' === $menu->grid_where_like and $menu->submenu) {
                if ($menu->submenu and $submenu) {
                    $gridQuery->andWhere(['LIKE', $menu->submenu, $submenu]);
                } else {
                    throw new ServerErrorHttpException('587: set submenu in menu and in grid');
                }
            }
            $gridDataProvider = new ActiveDataProvider([
                'query' => $gridQuery,
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_ASC,
                    ]
                ],
                'pagination' => false,
            ]);
        }

        return $this->render('manu', compact('charts', 'menu', 'submenu', 'gridDataProvider') + $params);
    }

    private static function getChartInfo(MenuChart $menuChart, ?string $submenuTitle = null)
    {
        $menu = Crud::findOrFail(Menu::find()->andWhere(['id' => $menuChart->menu_id])->andWhere(['deleted_at' => null]));

        $query = MenuContent::getMenuContentBaseQuery($menu->id);
        //chart_axis_x and chart_aggregation
        if ($menuChart->chart_aggregation) {
            $selectExpression = Helper::getSafeExpression($menuChart->chart_aggregation, $menuChart->chart_axis_y);
            $query->groupBy($menuChart->chart_axis_y);
        } else {
            $selectExpression = $menuChart->chart_axis_y;
            $query->groupBy('id');
        }
        $query->addSelect(['axis_x' => $menuChart->chart_axis_x]);
        $query->addSelect(['axis_y' => $selectExpression]);
        //chart_where_like
        if ('submenu' === $menuChart->chart_where_like and $menu->submenu) {
            if ($submenuTitle) {
                $query->andWhere(['LIKE', $menu->submenu, $submenuTitle]);
            } else {
                throw new ServerErrorHttpException('586: set submenu in menu and in field');
            }
        }

        $result = $query->all();

        $axisX = ArrayHelper::getColumn($result, 'axis_x');
        $axisY = ArrayHelper::getColumn($result, 'axis_y');
        $axisY = array_map('doubleval', $axisY);

        return [
            'id' => $menuChart->id,
            'div_id' => 'chart_' . $menuChart->id,
            'title' => $menuChart->title,
            'axis_x' => $axisX,
            'axis_y' => $axisY,
            'width_12' => $menuChart->chart_width_12,
            'chart_type' => $menuChart->chart_type,
        ];
    }
}
