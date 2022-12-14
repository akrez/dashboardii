<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the model class for table "menu_charts".
 *
 * @property int $id
 * @property string $title
 * @property string|null $chart_aggregation
 * @property string|null $chart_axis_x
 * @property string|null $chart_where_like
 * @property string|null $chart_axis_y
 * @property string|null $chart_group_by
 * @property int|null $priority
 * @property string $chart_type
 * @property int $menu_id
 * @property int $chart_width_12
 * @property string|null $deleted_at
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Menus $menu
 */
class MenuChart extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menu_charts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['chart_width_12'], 'required'],
            [['chart_width_12'], 'integer', 'min' => 1, 'max' => 12],
            [['priority'], 'integer'],
            [['title'], 'string', 'max' => 255],
            //
            [['chart_axis_x'], 'required'],
            [['chart_axis_x'], 'in', 'range' => Menu::getPossibleHeadersList()],
            [['chart_axis_y'], 'required'],
            [['chart_axis_y'], 'in', 'range' => Menu::getPossibleHeadersList()],
            [['chart_group_by'], 'in', 'range' => Menu::getPossibleHeadersList()],
            [['chart_type'], 'required'],
            [['chart_type'], 'in', 'range' => array_keys(static::getMenuChartTypesList())],
            [['chart_aggregation'], 'in', 'range' => array_keys(static::getMenuChartAggregationsList())],
            [['chart_where_like'], 'string', 'max' => 12],
        ];
    }

    public static function getMenuChartWhereLikesList()
    {
        return [
            'submenu' => 'برابر ساب منو باشد',
        ];
    }

    public static function getMenuChartWhereLikesTitle($item)
    {
        $list = static::getMenuChartWhereLikesList();
        if (isset($list[$item])) {
            return $list[$item];
        }
        return '';
    }

    public static function getMenuChartAggregationsList()
    {
        return [
            null => 'خود ستون',
            'MAX' => 'بیشترین',
            'MIN' => 'کمترین',
            'COUNT' => 'تعداد',
        ];
    }

    public static function getMenuChartAggregationTitle($item)
    {
        $list = static::getMenuChartAggregationsList();
        if (isset($list[$item])) {
            return $list[$item];
        }
        return '';
    }

    public static function getMenuChartTypesList()
    {
        return [
            'bar' => 'ستونی',
            'pie' => 'پای',
        ];
    }

    public static function getMenuChartTypeTitle($item)
    {
        $list = static::getMenuChartTypesList();
        if (isset($list[$item])) {
            return $list[$item];
        }
        return '';
    }

    public static function getMenuChartBaseFindQuery($menuId): ActiveQuery
    {
        $query = self::find();
        $query->andWhere(['menu_id' => $menuId]);
        $query->andWhere(['deleted_at' => null]);
        return $query;
    }
}
