<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AdminLteAsset;
use app\components\AdminLteCustom;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\web\View;

AdminLteAsset::register($this);
//
$this->registerJs("
$(document).on('click','.btn[toggle]',function() {

    var btn = $(this);
    var isHidden = $(btn.attr('toggle')).is(':hidden');    

    $('.btn[toggle]').each(function(i) {
        var toggleBtn = $(this);
        $(toggleBtn.attr('toggle')).hide();
        toggleBtn.addClass('btn-default');
        toggleBtn.removeClass('btn-warning');
    });

    if(isHidden) {
        $(btn.attr('toggle')).show();
        btn.addClass('btn-warning');
        btn.removeClass('btn-default');
    }

});
$(document).on('pjax:beforeSend', function(xhr, options) {
    $('.ajax-splash-show').css('display','inline-block');
    $('.ajax-splash-hide').css('display','none');
});
$(document).on('pjax:complete', function(xhr, textStatus, options) {
    $('.ajax-splash-show').css('display','none');
    $('.ajax-splash-hide').css('display','inline-block');
});
", View::POS_READY);
$this->registerCss("
.splash-style {
    background-image: url('" . Yii::getAlias('@web/img/loading.svg') . "');
    display: none;
    background-color: rgba(0, 0, 0, 0.67);
    inset: 0px;
    position: absolute;
    z-index: 9998;
    background-repeat: no-repeat;
    background-position: center;
}
.sidebar-mini.sidebar-collapse .user-panel {
    display: none !important;
    -webkit-transform: translateZ(0);
}
.table th {
    vertical-align: top !important;
}
.table td {
    vertical-align: middle !important;
}
.position-relative {
    .position: relative;
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
                    <?php echo AdminLteCustom::renderMenu(); ?>
                </section>
            </aside>
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper position-relative">
            <div class="ajax-splash-show splash-style"></div>
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