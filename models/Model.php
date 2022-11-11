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
            'name' => 'نام',
            'mobile' => 'شماره موبایل',
            'title' => 'عنوان',
            'menu_id' => 'منو',
            'deleted_at' => 'تاریخ حذف',
            'submenu' => 'ساب منو به ازای هر',
            'chart_axis_y' => 'محور عمودی',
            'chart_group_by' => 'دسته‌بندی بر اساس',
            'chart_where_like' => 'ردیف هایی نمایش داده شوند که',
            'chart_axis_x' => 'محور افقی',
            'chart_aggregation' => 'نتیجه بر اساس',
            'priority' => 'اولویت',
            'chart_width_12' => 'سهم عرض از 12',
            'content' => 'محتوا',
            'chart_type' => 'نوع چارت',
            'grid_where_like' => 'مقادیری در جدول نمایش',
            'user_id' => 'کاربر',
        ];
    }
}
