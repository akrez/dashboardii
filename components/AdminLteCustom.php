<?php

namespace app\components;

use app\models\User;
use Yii;
use yii\helpers\Url;

class AdminLteCustom extends AdminLte
{
    public static function getTitleText()
    {
        if (null !== self::$titleText) {
            return  self::$titleText;
        }

        return Yii::$app->name;
    }

    public static function getTitleLink()
    {
        if (null !== self::$titleLink) {
            return  self::$titleLink;
        }

        return Url::to(['site/index']);
    }

    public static function getLogoSrc()
    {
        if (null !== self::$logoSrc) {
            return  self::$logoSrc;
        }

        return null;
        return Yii::getAlias('@web/img/logo.png');
    }

    public static function getMenuTitle()
    {
        if (null !== self::$menuTitle) {
            return  self::$menuTitle;
        }

        return 'منوی اصلی';
    }

    public static function getNavList()
    {
        if (null !== self::$navList) {
            return  self::$navList;
        }
        $navs = [];

        if (Yii::$app->user->isGuest) {

            $navs[] = [
                'link' => Url::toRoute(User::getSigninUrl()),
                'title' => Yii::t('app', 'Signin'),
                'options' => ['class' => 'pl-0'],
            ];
        } else {
            $navs[] = [
                'link' => Url::toRoute(['/users/signout']),
                'title' => Yii::t('app', 'Signout'),
                'options' => ['onclick' => "event.preventDefault(); document.getElementById('logout-form').submit();"],
            ];
        }

        return $navs;
    }

    public static function getMenuList()
    {
        if (null !== self::$menuList) {
            return  self::$menuList;
        }

        return [
            [
                'link' => 'Z',
                'title' => 'ZZ',
                'icon' => 'fa fa-user',
                'items' => [
                    [
                        'link' => 'Z',
                        'title' => 'ZZ',
                        'icon' => 'fa fa-user',
                        'items' => [],
                    ],
                    [
                        'link' => 'Z',
                        'title' => 'ZZ',
                        'icon' => 'fa fa-user',
                        'items' => [],
                    ],
                    [
                        'link' => 'Z',
                        'title' => 'ZZ',
                        'icon' => 'fa fa-user',
                        'items' => [],
                    ],
                ],

            ],
            [
                'link' => 'Z',
                'title' => 'ZZ',
                'icon' => 'fa fa-user',
                'items' => [],
            ],
        ];
    }

    public static function isCollapse()
    {
        return Yii::$app->session->get('__sidebar', false);
    }
}
