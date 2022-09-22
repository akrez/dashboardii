<?php

namespace app\assets;

use yii\web\AssetBundle;

class ChartJsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'web/plugins/chart.js/Chart.min.css',
    ];
    public $js = [
        'web/plugins/chart.js/Chart.min.js',
    ];
    public $depends = [];
}
