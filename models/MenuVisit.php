<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu_visits".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $menu_id
 * @property string|null $submenu
 * @property string|null $created_at
 *
 * @property Menu $menu
 * @property User $user
 */
class MenuVisit extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_visits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'menu_id'], 'integer'],
            [['created_at'], 'safe'],
            [['submenu'], 'string', 'max' => 255],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function create($menuId, $submenu = null)
    {
        $model = new self();
        $model->user_id = Yii::$app->user->getId();
        $model->menu_id = $menuId;
        $model->submenu = $submenu;
        $model->user_agent = Yii::$app->request->getUserAgent();
        $model->created_at = date('Y-m-d H:i:s');
        $model->save(false);
    }
}
