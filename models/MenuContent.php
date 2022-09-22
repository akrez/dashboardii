<?php

namespace app\models;

use app\components\Helper;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%menu_contents}}".
 *
 * @property int $id
 * @property int $menu_id
 * @property string|null $deleted_at
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Menus $menu
 */

class MenuContent extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menu_contents}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['column_a', 'column_b', 'column_c', 'column_d', 'column_e', 'column_f', 'column_g', 'column_h', 'column_i', 'column_j', 'column_k', 'column_l', 'column_m', 'column_n', 'column_o', 'column_p', 'column_q', 'column_r', 'column_s', 'column_t', 'column_u', 'column_v', 'column_w', 'column_x', 'column_y', 'column_z'], 'string', 'max' => 255],
        ];
    }

    /**
     * Gets query for [[Menu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    public static function deleteByMenuId($menuId)
    {
        return MenuContent::deleteAll(['menu_id' => $menuId]);
    }

    public static function findMaxStep($menuId)
    {
        $max = MenuContent::find()->andWhere(['menu_id' => $menuId])->max('step');
        $max = intval($max);
        return $max + 1;
    }

    public static function getSubmenuArray($menu)
    {
        $submenuColumn = Helper::getSafeColumnName($menu->submenu);
        $submenuLengthExpr = Helper::getSafeExpression("LENGTH", $submenuColumn);
        //
        $query = MenuContent::getMenuContentBaseQuery($menu->id);
        $query->select($submenuColumn);
        $query->andWhere(['>', $submenuLengthExpr, 0]);
        $query->andWhere(['IS NOT', $submenuColumn, null]);
        $query->groupBy($submenuColumn);
        $query->orderBy($submenuColumn);
        return $query->column();
    }

    public static function getMenuContentBaseQuery($menuId): yii\db\Query
    {
        $query = new Query();
        $query->from(MenuContent::tableName());
        $query->andWhere(['menu_id' => $menuId]);
        $query->andWhere(['deleted_at' => null]);
        return $query;
    }

    public static function getMenuContentBaseFindQuery($menuId)
    {
        $query = MenuContent::find();
        $query->andWhere(['menu_id' => $menuId]);
        $query->andWhere(['deleted_at' => null]);
        return $query;
    }
}
