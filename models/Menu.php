<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%menus}}".
 *
 * @property int $id
 * @property string $title
 * @property int $user_id
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Menu extends ActiveRecord
{
    public $content;

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
        ];
    }
}
