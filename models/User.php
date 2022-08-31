<?php

namespace app\models;

use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int         $id
 * @property string      $name
 * @property string      $email
 * @property string|null $email_verified_at
 * @property string      $password
 * @property string|null $remember_token
 * @property string|null $api_token
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['email_verified_at', 'created_at', 'updated_at'], 'safe'],
            [['name', 'email', 'password'], 'string', 'max' => 255],
            [['remember_token'], 'string', 'max' => 100],
            [['api_token'], 'string', 'max' => 80],
            [['email'], 'unique'],
            [['api_token'], 'unique'],
        ];
    }

    /////

    public static function findIdentity($id)
    {
        return static::find()->where(['id' => $id])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->where(['api_token' => $token])->one();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->api_token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /////

    public static function findUserByEmail($email)
    {
        return User::find()->where(['email' => $email])->one();
    }
}
