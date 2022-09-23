<?php

namespace app\models;

class UserSignupForm extends UserSignup
{
    public $captcha;

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['captcha'], 'required'];
        $rules[] = [['captcha'], 'captcha'];

        return $rules;
    }
}
