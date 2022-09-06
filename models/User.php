<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
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

    public static function generatePasswordHash($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    public static function generateApiToken()
    {
        return Yii::$app->security->generateRandomString();
    }

    public static function validatePassword($password, $passwordHash)
    {
        return Yii::$app->security->validatePassword($password, $passwordHash);
    }

    public static function login(IdentityInterface $identity, $duration = 0)
    {
        return Yii::$app->user->login($identity, $duration);
    }

    public static function generateValidation($attributes, $customValidations = [], $uniqueAttributes = [])
    {
        $validations = [];

        foreach ($attributes as $attribute => $isRequired) {
            if ($attribute == 'email') {
                $validations[] = [['email'], 'email'];
            } elseif ($attribute == 'password') {
                $validations[] = [['password'], 'string', 'strict' => false, 'min' => 6];
            } elseif ($attribute == 'name') {
                $validations[] = [['name'], 'string', 'strict' => false, 'min' => 1];
            } elseif ($attribute == 'mobile') {
                $validations[] = [['mobile'], 'match', 'pattern' => '/^09[0-9]{9}$/'];
            }
            //
            if ($isRequired) {
                $validations[] = [[$attribute], 'required'];
            }
        }

        foreach ($uniqueAttributes as $attribute) {
            $validations[] = [[$attribute], 'unique', 'targetClass' => User::class,];
        }

        return array_merge($validations, $customValidations);
    }

    public static function getSigninUrl()
    {
        return Url::to('users/signin');
    }

    public static function deleteUnverifiedTimeoutedBlog()
    {
    }
}
