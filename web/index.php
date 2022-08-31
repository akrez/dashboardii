<?php

$config = require __DIR__ . '/../config/constants.php';

require VENDOR_PATH . '/autoload.php';
require VENDOR_PATH . '/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
