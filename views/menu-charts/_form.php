<?php

use app\models\MenuChart;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 *
 * @var MenuChart $model
 */

$form = ActiveForm::begin([
    'options' => ['data-pjax' => true],
    'action' => Url::current(['id' => $model->id, 'state' => ($model->isNewRecord ? 'create' : 'update'),]),
    'fieldConfig' => [
        'template' => '<div class="input-group">{label}{input}</div>{hint}{error}',
        'labelOptions' => [
            'class' => 'input-group-addon',
        ],
    ]
]);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'priority')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-sm-3">
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'chart_width_12')->textInput(['type' => 'number']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'chart_axis_x')->dropDownList($parentModel->getHeadersList()) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'chart_axis_y')->dropDownList($parentModel->getHeadersList(), [
                'prompt' => [
                    'text' => '',
                    'options' => [
                        'value' => null,
                    ],
                ],
            ]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'chart_aggregation')->dropDownList(MenuChart::getMenuChartAggregationsList()) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'chart_where_like')->dropDownList(MenuChart::getMenuChartWhereLikesList(), [
                'prompt' => [
                    'text' => '',
                    'options' => [
                        'value' => null,
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <?= Html::submitButton($model->isNewRecord ? ' <span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Create') : ' <span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('app', 'Update'), ['class' => 'btn btn-block btn-social ' . ($model->isNewRecord ? 'btn-success' : 'btn-primary')]); ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>