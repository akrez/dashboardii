<?php

namespace app\models;

use Yii;

class UserSignup extends Model
{
    private $user;
    public $name;
    public $email;
    public $mobile;
    public $captcha;
    public $password;

    public function rules()
    {
        return User::generateValidation(
            ['name' => true, 'email' => true, 'mobile' => true, 'password' => true],
            [
                [['captcha'], 'required'],
                [['captcha'], 'captcha'],
                [['password'], 'signupValidation'],
            ],
            ['email', 'mobile'],
        );
    }

    public function getUser()
    {
        return $this->user;
    }

    public function signupValidation($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->mobile = $this->mobile;
            $user->password = User::generatePasswordHash($this->password);
            $user->api_token = User::generateApiToken();
            $user->email_verified_at = null;
            $user->remember_token = null;
            if ($user->save()) {
                return $this->user = $user;
            }
            $this->addError($attribute, Yii::t('yii', 'An internal server error occurred.'));
        }

        return $this->user = null;
    }
}
