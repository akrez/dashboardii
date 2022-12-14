<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AdminLteAsset;
use app\components\AdminLteCustom;
use app\widgets\Alert;
use yii\helpers\Html;

AdminLteAsset::register($this);
//
$this->registerCss("
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

<body class="skin-blue sidebar-mini <?= AdminLteCustom::isCollapse() ? 'sidebar-collapse' : '' ?>">
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">
            <!-- Logo -->
            <?php echo AdminLteCustom::renderTitle(); ?>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only"> </span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <?= AdminLteCustom::renderNavList() ?>
                    </ul>
                    <?= Html::beginForm(['/users/signout'], 'POST', ["id" => "logout-form", "style" => "display: none;",]) . Html::endForm() ?>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <aside class="main-sidebar direction">
                <section class="sidebar">
                    <?php echo AdminLteCustom::renderLogo(); ?>
                    <?php echo AdminLteCustom::renderMenuList(); ?>
                </section>
            </aside>
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper position-relative">
            <!-- Content Header (Page header) -->
            <div class="col-xs-12">
                <br />
                <?= Alert::widget() ?>
            </div>
            <!-- Main content -->
            <section class="content">
                <?= $content ?>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>