<?php

namespace app\components;

use app\models\User;
use Yii;
use yii\base\Component as BaseComponent;
use yii\helpers\Html;
use yii\helpers\Url;

class AdminLte extends BaseComponent
{
    private static $titleText;
    private static $titleLink;
    private static $logoSrc;
    private static $menuTitle;
    private static $navList;
    private static $menuList;

    //

    public static function setTitleText(?string $text)
    {
        self::$titleText = $text;
    }

    public static function setTitleLink(?string $link)
    {
        self::$titleLink = $link;
    }

    public static function setLogoSrc(?string $link)
    {
        self::$logoSrc = $link;
    }

    public static function setMenuTitle(?string $title)
    {
        self::$menuTitle = $title;
    }

    public static function setNavList(?array $list)
    {
        self::$navList = $list;
    }

    public static function setMenuList(?array $list)
    {
        self::$menuList = $list;
    }

    //

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
                'items' => [],
            ],
        ];
    }

    public static function isCollapse()
    {
        return Yii::$app->session->get('__sidebar', false);
    }

    public static function renderNavList()
    {
        $result = '';

        foreach (self::getNavList() as $nav) {
            $nav = $nav + [
                'title' => '',
                'link' => '',
                'options' => [],
            ];
            $result .= ('<li class="dropdown">' . Html::a(Html::tag('span', $nav['title'], $nav['options']), $nav['link']) . '</li>');
        }

        return $result;
    }

    public static function renderTitle()
    {
        $result = '';

        $text = self::getTitleText();
        $link = self::getTitleLink();

        if ($text) {
            $logoMini = '<span class="logo-mini">' . Html::tag('b', mb_substr($text, 0, 1)) . '</span>';
            $logo = '<span class="logo-lg">' . Html::tag('b', $text) . '</span>';

            $result = Html::a($logoMini . $logo, $link, ['class' => 'logo']);
        }

        return $result;
    }

    public static function renderLogo()
    {
        $result = '';

        $logoSrc = self::getLogoSrc();
        if ($logoSrc) {
            $result = '<div class="user-panel"><div class="header" style="padding-left: 10px;padding-right: 10px;">' . Html::img($logoSrc, [
                'class' => 'img img-responsive',
                'style' => 'min-width: 100%;',
            ]) . '</div></div>';
        }

        return $result;
    }

    public static function renderMenu()
    {
        $result = '';

        $menuList = AdminLte::renderMenuList();
        if ($menuList) {
            $result = '<ul class="sidebar-menu">' . AdminLte::renderMenuTitle() . $menuList . '</ul>';
        }

        return $result;
    }

    private static function renderMenuTitle()
    {
        $result = '';

        $menuTitle = self::getMenuTitle();

        if ($menuTitle) {
            $result = Html::tag('li', $menuTitle, ['class' => 'header']);
        }

        return $result;
    }

    private static function renderMenuList()
    {
        $result = '';

        $menuList = self::getMenuList();
        foreach ($menuList as $menu) {
            $result .= self::renderMenuLi($menu);
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
            $append .= self::renderMenuLi($menuItem);
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
