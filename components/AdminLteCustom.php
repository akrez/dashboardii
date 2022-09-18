<?php

namespace app\components;

use app\models\Menu;
use app\models\MenuChart;
use app\models\User;
use Yii;
use yii\helpers\Url;

class AdminLteCustom extends AdminLte
{
    public static function getTitleText()
    {
        if (null !== self::$titleText) {
            return self::$titleText;
        }

        return Yii::$app->name;
    }

    public static function getTitleLink()
    {
        if (null !== self::$titleLink) {
            return self::$titleLink;
        }

        return Url::to(['site/index']);
    }

    public static function getLogoSrc()
    {
        if (null !== self::$logoSrc) {
            return self::$logoSrc;
        }

        return null;
        return Yii::getAlias('@web/img/logo.png');
    }

    public static function getNavList()
    {
        if (null !== self::$navList) {
            return self::$navList;
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
            return self::$menuList;
        }

        $menuList = [];

        if (Yii::$app->user->isGuest) {
        } else {
            $menuList[] = 'منوی اصلی';

            $menuList[] = [
                'link' => Url::toRoute(['/menus']),
                'title' => Yii::t('app', 'Menus'),
                'icon' => 'fa fa-cog',
                'items' => [],
            ];

            $menuList[] = Yii::t('app', 'Menus');

            $userMenus = Menu::getUserMenus(Yii::$app->user->getId());
            foreach ($userMenus as $userMenu) {
                $item = [
                    'link' => '',
                    'title' => $userMenu->title,
                    'icon' => 'fa fa-chart-line',
                    'items' => [],
                ];
                $submenus = Menu::getSubmenuArray($userMenu);
                if ($submenus === null) {
                    $item['link'] = Url::to([
                        'charts/menu',
                        'id' => $userMenu->id,
                        'submenu' => null,
                    ]);
                } else {
                    $item['icon'] = 'fa fa-chart-area';
                    foreach ($submenus as $submenu) {
                        $item['items'][] = [
                            'title' => $submenu,
                            'icon' => 'fa fa-chart-bar',
                            'items' => [],
                            'link' => Url::to([
                                'charts/menu',
                                'id' => $userMenu->id,
                                'submenu' => $submenu,
                            ]),
                        ];
                    }
                }
                $menuList[] = $item;
            }
        }

        return $menuList;
    }

    public static function isCollapse()
    {
        return Yii::$app->session->get('__sidebar', false);
    }
}
