<?php

namespace app\components;

use yii\base\Component as BaseComponent;
use yii\helpers\Html;

class AdminLte extends BaseComponent
{
    protected static $titleText;
    protected static $titleLink;
    protected static $logoSrc;
    protected static $menuTitle;
    protected static $navList;
    protected static $menuList;
    protected static $collapse;

    public static function setTitleText(?string $text)
    {
        static::$titleText = $text;
    }

    public static function setTitleLink(?string $link)
    {
        static::$titleLink = $link;
    }

    public static function setLogoSrc(?string $link)
    {
        static::$logoSrc = $link;
    }

    public static function setMenuTitle(?string $title)
    {
        static::$menuTitle = $title;
    }

    public static function setNavList(?array $list)
    {
        static::$navList = $list;
    }

    public static function setMenuList(?array $list)
    {
        static::$menuList = $list;
    }

    public static function getTitleText()
    {
        return static::$titleText;
    }

    public static function getTitleLink()
    {
        return static::$titleLink;
    }

    public static function getLogoSrc()
    {
        return static::$logoSrc;
    }

    public static function getMenuTitle()
    {
        return static::$menuTitle;
    }

    public static function getNavList()
    {
        return static::$navList;
    }

    public static function getMenuList()
    {
        return static::$menuList;
    }

    public static function isCollapse()
    {
        return static::$collapse;
    }

    public static function renderNavList()
    {
        $result = '';

        $navs = static::getNavList();
        if (empty($navs)) {
            return $result;
        }

        foreach ($navs as $nav) {
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

        $text = static::getTitleText();
        $link = static::getTitleLink();
        if (empty($text)) {
            return $result;
        }

        $logoMini = '<span class="logo-mini">' . Html::tag('b', mb_substr($text, 0, 1)) . '</span>';
        $logo = '<span class="logo-lg">' . Html::tag('b', $text) . '</span>';

        $result = Html::a($logoMini . $logo, $link, ['class' => 'logo']);

        return $result;
    }

    public static function renderLogo()
    {
        $result = '';

        $logoSrc = static::getLogoSrc();
        if (empty($logoSrc)) {
            return $result;
        }

        $result = '<div class="user-panel"><div class="header" style="padding-left: 10px;padding-right: 10px;">' . Html::img($logoSrc, [
            'class' => 'img img-responsive',
            'style' => 'min-width: 100%;',
        ]) . '</div></div>';

        return $result;
    }

    public static function renderMenu()
    {
        $result = '';

        $menuList = static::renderMenuList();
        if (empty($menuList)) {
            return $result;
        }

        $result = '<ul class="sidebar-menu">' . static::renderMenuTitle() . $menuList . '</ul>';

        return $result;
    }

    protected static function renderMenuTitle()
    {
        $result = '';

        $menuTitle = static::getMenuTitle();
        if (empty($menuTitle)) {
            return $result;
        }

        $result = Html::tag('li', $menuTitle, ['class' => 'header']);

        return $result;
    }

    protected static function renderMenuList()
    {
        $result = '';

        $menuList = static::getMenuList();
        if (empty($menuList)) {
            return $result;
        }

        foreach ($menuList as $menu) {
            $result .= static::renderMenuLi($menu);
        }

        return $result;
    }

    protected static function renderMenuLi($menu)
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

        $liClass = ($menu['items'] ? 'treeview' : '');
        return '<li class="' . $liClass . '">' . Html::tag('a', $iconTag . $titleTag, ['href' => $menu['link']]) . $appendTag . '</li>';
    }
}
