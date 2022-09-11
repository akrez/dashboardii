<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%menu_charts}}".
 *
 * @property int $id
 * @property int $menu_id
 * @property string|null $chart_group_by
 * @property string|null $chart_where_like
 * @property string|null $chart_select
 * @property int|null $priority
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
            [['chart_width_12'], 'required'],
            [['chart_width_12'], 'integer', 'min' => 1, 'max' => 12],
            [['priority'], 'integer'],
            //
            [['chart_group_by', 'chart_where_like', 'chart_select'], 'string', 'max' => 12],
        ];
    }

    /**
     * Gets query for [[Menu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menus::className(), ['id' => 'menu_id']);
    }
}
