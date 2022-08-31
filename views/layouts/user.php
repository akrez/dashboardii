<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AdminLteAsset;
use app\components\AdminLte;
use app\widgets\Alert;
use yii\helpers\Html;

AdminLteAsset::register($this);
//
$this->registerJs('
');
$this->registerCss("
.splash-style {
    background-image: url('" . Yii::getAlias('@web/cdn/img/loading.svg') . "');
}
.sidebar-mini.sidebar-collapse .user-panel {
    display: none !important;
    -webkit-transform: translateZ(0);
}
");
//
$this->title = Html::encode($this->title ? $this->title : Yii::$app->name);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= Yii::$app->view->registerLinkTag(['rel' => 'icon', 'href' => Yii::getAlias('@web/logo.png')]) ?>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= $this->title ?></title>
    <?php $this->head() ?>
</head>

<body class="hold-transition login-page">
    <?php $this->beginBody() ?>
    <div class="login-box">
        <div class="login-logo">
            <?= $this->title ?>
        </div>
        <div class="login-box-body">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>