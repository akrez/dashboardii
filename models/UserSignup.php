<?php

namespace app\models;

use Yii;

class UserSignup extends Model
{
    private $user;
    public $name;
    public $email;
    public $mobile;
    public $password;

    public function rules()
    {
        return User::generateValidation(
            ['name' => true, 'email' => true, 'mobile' => true, 'password' => true],
            [],
            ['email', 'mobile'],
        );
    }

    public function getUser()
    {
        return $this->user;
    }

    public function signup()
    {
        $this->user = null;

        if ($this->validate()) {
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->mobile = $this->mobile;
            $user->password = User::generatePasswordHash($this->password);
            $user->api_token = User::generateApiToken();
            $user->email_verified_at = null;
            $user->email_verified_at = null;
            $user->remember_token = null;
            if ($user->save()) {
                $this->user = $user;
            }
        }

        return $this->user;
    }
}
