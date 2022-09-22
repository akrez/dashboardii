<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "menus".
 *
 * @property int $id
 * @property string $title
 * @property int $user_id
 * @property string|null $headers
 * @property string|null $submenu
 * @property string|null $grid_where_like
 * @property string|null $deleted_at
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property MenuCharts[] $menuCharts
 * @property MenuContents[] $menuContents
 * @property Users $user
 */
class Menu extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menus}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['submenu'], 'in', 'range' => array_keys($this->getHeadersList())],
            [['grid_where_like'], 'in', 'range' => array_keys(static::getMenuGridWhereLikesList())],
        ];
    }

    public static function getMenuGridWhereLikesList()
    {
        return [
            null => 'نمایش داده نشود',
            'submenu' => 'برابر ساب منو باشد',
            'all' => 'همه را نشان بده',
        ];
    }

    public static function getMenuGridWhereLikesTitle($item)
    {
        $list = static::getMenuGridWhereLikesList();
        if (isset($list[$item])) {
            return $list[$item];
        }
        return '';
    }

    public function saveHeaders(array $headers)
    {
        $headers = array_filter($headers, 'strlen');
        $this->headers = json_encode($headers);
        return $this->save();
    }

    public static function getPossibleHeadersList()
    {
        $items = range('a', 'z');
        return array_map(function ($item) {
            return 'column_' . $item;
        }, $items);
    }

    public static function getMenuBaseFindQuery($userId = null, $id = null): ActiveQuery
    {
        $query = self::find();
        $query->andWhere(['deleted_at' => null]);
        if (null !== $userId) {
            $query->andWhere(['user_id' => $userId]);
        }
        if (null !== $id) {
            $query->andWhere(['id' => $id]);
        }
        return $query;
    }

    /**
     * @return MenuChart[]
     */
    public static function getUserMenus($userId): array
    {
        return self::getMenuBaseFindQuery(intval($userId))->all();
    }

    public static function getSubmenuArray($menu): ?array
    {
        if ($menu->submenu) {
            return MenuContent::getSubmenuArray($menu);
        }
        return null;
    }

    public function getHeadersList()
    {
        return (array)json_decode($this->headers, true);
    }

    public function getHeaderTitle($submenu)
    {
        $list = $this->getHeadersList();
        if (isset($list[$submenu])) {
            return $list[$submenu];
        }
        return '';
    }
}
