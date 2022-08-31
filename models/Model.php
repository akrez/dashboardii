<?php

namespace app\models;

use yii\base\Model as BaseModel;

class Model extends BaseModel
{

    public function attributeLabels()
    {
        return static::attributeLabelsList();
    }

    public static function attributeLabelsList()
    {
        return [
            'id' => 'شناسه',
            'updated_at' => 'تاریخ ویرایش',
            'created_at' => 'تاریخ ایجاد',
            'status' => 'وضعیت',
            'email' => 'ایمیل',
            'captcha' => 'کد تأیید',
            'password' => 'پسورد',
            'remember_me' => 'مرا به خاطر بسپار',
        ];
    }
}
