<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int         $id
 * @property string      $name
 * @property string      $email
 * @property string|null $email_verified_at
 * @property string      $password
 * @property string|null $remember_token
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class UserSignin extends Model
{
    private $user;
    public $email;
    public $captcha;
    public $password;
    public $remember_me = true;

    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            [['captcha'], 'required'],
            [['captcha'], 'captcha'],
            [['remember_me'], 'boolean'],
            [['password'], 'required'],
            [['password'], 'string', 'strict' => false, 'min' => 6],
            [['password'], 'signinValidation'],
        ];
    }

    public function getUser()
    {
        return $this->user;
    }

    public function signinValidation($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findUserByEmail($this->email);
            if ($user && $this->validatePassword($this->password, $user->password)) {
                return $this->user = $user;
            }
            $this->addError($attribute, Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel($attribute)]));
        }

        return $this->user = null;
    }

    public function validatePassword($password, $passwordHash)
    {
        return Yii::$app->security->validatePassword($password, $passwordHash);
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function signin()
    {
        if ($this->validate() and $this->getUser()) {
            return Yii::$app->user->login($this->getUser(), $this->remember_me ? 3600 * 24 * 30 : 0);
        }

        return false;
    }
}
