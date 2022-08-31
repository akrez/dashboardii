<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AdminLteAsset;
use app\components\AdminLte;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;

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

<body>
    <?php $this->beginBody() ?>
    <div class="container mt-5">
        <nav id="navbar" class="navbar navbar-default">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>"><?= Yii::$app->name ?></a>
            </div>
            <div id="navbar-collapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <?php if (Yii::$app->user->isGuest) : ?>
                        <li><a href="<?= Url::toRoute(['/user/signin']) ?>" style="padding-left: 0;"><?= Yii::t('app', 'Signin') ?></a></li>
                    <?php else : ?>
                        <li><a href="<?= Url::toRoute(['/user/signout']) ?>"><?= Yii::t('app', 'Signout') ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>