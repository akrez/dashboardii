<?php

use yii\web\View;
use yii\widgets\Pjax;
use app\widgets\Alert;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Menus');

$this->registerCss("
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
?>
<h3 class="pb20"><?= Html::encode($this->title) ?></h3>
<?php
Pjax::begin([
    'id' => 'grid-pjax',
    'timeout' => false,
    'enablePushState' => false,
]);
?>
<div class="row">
    <div class="col-sm-12">
        <?= Alert::widget() ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-primary position-relative">
            <div class="ajax-splash-show splash-style"></div>
            <?php
            $columns = [
                'id',
                'title',
                [
                    'value' => function ($dataProviderModel) use ($model, $state) {
                        $btnClass = ' btn-default ';
                        if ($model && $model->id == $dataProviderModel->id && $state == 'update') {
                            $btnClass = ' btn-warning ';
                        }
                        return Html::button(Yii::t('app', 'Edit'), ['class' => 'btn btn-block' . $btnClass, 'toggle' => "#row-update-" . $dataProviderModel->id]);
                    },
                    'format' => 'raw',
                ],
            ];
            $afterRow = function ($dataProviderModel) use ($model, $state, $parentModel, $columns) {
                $displayStyle = 'display: none;';
                if ($model && $model->id == $dataProviderModel->id) {
                    $dataProviderModel = $model;
                    $displayStyle = 'display: table-row;';
                }
                //
                ob_start();
                echo $this->render('_form', ['model' => $dataProviderModel, 'parentModel' => $parentModel]);
                $formContent = ob_get_contents();
                ob_end_clean();
                //
                return Html::beginTag('tr', [
                    'style' => $displayStyle,
                    'id' => "row-update-" . $dataProviderModel->id,
                ]) . '<td class="p-3" colspan="' . count($columns) . '"> ' . $formContent . ' </td></tr>';
            };
            echo GridView::widget([
                'layout' => '{items}',
                'tableOptions' => ['class' => 'table table-bordered table-striped'],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'options' => ['class' => 'table-responsive'],
                'columns' => $columns,
                'afterRow' => $afterRow,
            ]);
            ?>
            <div class="panel-footer panel-success p-3">
                <?= $this->render('_form', ['model' => $newModel, 'parentModel' => $parentModel]); ?>
            </div>
        </div>
    </div>
</div>
<?php
echo LinkPager::widget([
    'pagination' => $dataProvider->getPagination(),
    'options' => [
        'class' => 'pagination',
    ]
]);
Pjax::end();
?>