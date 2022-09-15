<?php

use yii\web\View;
use yii\widgets\Pjax;
use app\widgets\Alert;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Html;

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
.table th {
    vertical-align: top !important;
}
.table td {
    vertical-align: middle !important;
}
");

$this->title = $title;

?>
<h3 class="pb20"><?= Html::encode($this->title) ?></h3>
<?php
Pjax::begin([
    'id' => 'grid-pjax',
    'timeout' => false,
    'enablePushState' => false,
]);
?>
<div class="ajax-splash-show splash-style"></div>
<div class="row">
    <div class="col-sm-12">
        <?= Alert::widget() ?>
    </div>
</div>
<div class="row">
    <?php
    $newFormContent = $newForm();
    if ($newFormContent) {
    ?>
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-footer panel-success p-3">
                    <?= $newFormContent; ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="col-sm-12">
        <div class="panel panel-primary">
            <?php
            echo GridView::widget([
                'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                'layout' => '{items}',
                'tableOptions' => ['class' => 'table table-bordered table-striped'],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'options' => ['class' => 'table-responsive'],
                'columns' => $columns,
                'afterRow' => $afterRow,
            ]);
            ?>
        </div>
    </div>
</div>
<?php
if ($pagination) {
    echo LinkPager::widget([
        'pagination' => $pagination,
        'options' => [
            'class' => 'pagination',
        ]
    ]);
}
Pjax::end();
?>