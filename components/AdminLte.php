<?php

namespace app\components;

use Yii;
use yii\base\Component as BaseComponent;
use yii\helpers\Html;
use yii\helpers\Url;

class AdminLte extends BaseComponent
{
    public static function isCollapse()
    {
        return Yii::$app->session->get('__sidebar', false);
    }

    public static function getTitleText()
    {
        return Yii::$app->name;
    }

    public static function getTitleLink()
    {
        return Url::to(['site/index']);
    }

    public static function getLogo()
    {
        return Yii::getAlias('@web/img/logo.png');
    }

    public static function getMenuTitle()
    {
        return 'منوی اصلی';
    }

    public static function getNavList()
    {
        $navs = [];
        if (Yii::$app->user->getId()) {
            $navs[] = [
                'link' => Url::toRoute(['/user/signout']),
                'title' => Yii::t('app', 'Signout'),
                'options' => ['onclick' => "event.preventDefault(); document.getElementById('logout-form').submit();"],
            ];
        } else {
            $navs[] = [
                'link' => Url::toRoute(['/user/signin']),
                'title' => Yii::t('app', 'Signin'),
            ];
        }

        return $navs;
    }

    public static function getMenuList()
    {
        return [
            [
                'link' => 'A',
                'title' => 'AA',
                'icon' => 'fa fa-user',
                'items' => [
                    [
                        'link' => 'B',
                        'title' => 'BB',
                        'icon' => 'fa fa-user',
                        'items' => [],
                    ],
                    [
                        'link' => 'C',
                        'title' => 'CC',
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

    public static function renderNavList($navList, $isVisible = true)
    {
        $result = '';

        if (!$isVisible) {
            return $result;
        }

        foreach ($navList as $nav) {
            $nav = $nav + [
                'title' => '',
                'link' => '',
                'options' => [],
            ];
            $result .= ('<li class="dropdown">' . Html::a(Html::tag('span', $nav['title'], $nav['options']), $nav['link']) . '</li>');
        }

        return $result;
    }

    public static function renderTitle($link, $text, $isVisible = true)
    {
        $result = '';

        if (!$isVisible) {
            return $result;
        }

        $logoMini = '<span class="logo-mini">' . Html::tag('b', mb_substr($text, 0, 1)) . '</span>';
        $logo = '<span class="logo-lg">' . Html::tag('b', $text) . '</span>';

        $result = Html::a($logoMini . $logo, $link, ['class' => 'logo']);

        return $result;
    }

    public static function renderLogo($logo, $isVisible = true)
    {
        $result = '';

        if (!$isVisible) {
            return $result;
        }

        if ($logo) {
            $result = '<div class="header" style="padding-left: 10px;padding-right: 10px;">' . Html::img($logo, [
                'class' => 'img img-responsive',
                'style' => 'min-width: 100%;',
            ]) . '</div>';
        }

        return $result;
    }

    public static function renderMenuTitle($menuTitle, $isVisible = true)
    {
        $result = '';

        if (!$isVisible) {
            return $result;
        }

        if ($menuTitle) {
            $result = Html::tag('li', $menuTitle, ['class' => 'header']);
        }

        return $result;
    }

    public static function renderMenuList($menuList, $isVisible = true)
    {
        $result = '';

        if (!$isVisible) {
            return $result;
        }

        foreach ($menuList as $menu) {
            $result .= static::renderMenuLi($menu);
        }

        return $result;
    }

    private static function renderMenuLi($menu)
    {
        $menu = $menu + [
            'title' => null,
            'icon' => null,
            'link' => null,
            'items' => [],
        ];

        $append = '';
        foreach ($menu['items'] as $menuItem) {
            $append .= static::renderMenuLi($menuItem);
        }

        $appendTag = '';
        if ($append) {
            $appendTag = '<ul class="treeview-menu">' . $append . '</ul>';
        }

        $titleTag = Html::tag('span', $menu['title'], [
            'style' => 'margin-right: -2px;',
        ]);

        $iconTag = '';
        if ($menu['icon']) {
            $iconTag = Html::tag('i', '', ['class' => $menu['icon']]);
        }

        return '<li class="treeview">' . Html::tag('a', $iconTag . $titleTag, ['href' => $menu['link']]) . $appendTag . '</li>';
    }
}
