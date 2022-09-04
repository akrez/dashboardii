<?php

namespace app\models;

use Yii;

class UserSignin extends Model
{
    private $user;
    public $email;
    public $captcha;
    public $password;
    public $remember_me = true;

    public function rules()
    {
        return User::generateValidation(
            ['email' => true, 'password' => true],
            [
                [['captcha'], 'required'],
                [['captcha'], 'captcha'],
                [['remember_me'], 'boolean'],
                [['password'], 'signinValidation'],
            ],
        );
    }

    public function getUser()
    {
        return $this->user;
    }

    public function signinValidation($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findUserByEmail($this->email);
            if ($user && User::validatePassword($this->password, $user->password)) {
                return $this->user = $user;
            }
            $this->addError($attribute, Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel($attribute)]));
        }

        return $this->user = null;
    }
}
