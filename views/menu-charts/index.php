<?php

use yii\helpers\Html;

$columns = [
    'title',
    'priority',
    'chart_width_12',
    //
    [
        'attribute' => 'chart_axis_x',
        'value' => function ($dataProviderModel) use ($parentModel) {
            if ($parentModel) {
                return $parentModel->getHeaderTitle($dataProviderModel->chart_axis_x);
            }
        },
    ],
    [
        'attribute' => 'chart_aggregation',
        'value' => function ($dataProviderModel) use ($parentModel) {
            return $dataProviderModel::getMenuChartAggregationTitle($dataProviderModel->chart_aggregation);
        },
    ],
    [
        'attribute' => 'chart_axis_y',
        'value' => function ($dataProviderModel) use ($parentModel) {
            if ($parentModel) {
                return $parentModel->getHeaderTitle($dataProviderModel->chart_axis_y);
            }
            return '';
        },
    ],
    [
        'attribute' => 'chart_where_like',
        'value' => function ($dataProviderModel) use ($parentModel) {
            return $dataProviderModel::getMenuChartWhereLikesTitle($dataProviderModel->chart_where_like);
        },
    ],
    //
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
    echo $this->render('../menu-charts/_form', ['model' => $dataProviderModel, 'parentModel' => $parentModel]);
    $formContent = ob_get_contents();
    ob_end_clean();
    //
    return Html::beginTag('tr', [
        'style' => $displayStyle,
        'id' => "row-update-" . $dataProviderModel->id,
    ]) . '<td class="p-3" colspan="' . count($columns) . '"> ' . $formContent . ' </td></tr>';
};
$newForm = function () use ($newModel, $parentModel) {
    ob_start();
    echo $this->render('../menu-charts/_form', [
        'model' => $newModel,
        'parentModel' => $parentModel,
    ]);
    $formContent = ob_get_contents();
    ob_end_clean();

    return $formContent;
};

echo $this->render('/layouts/grid', [
    'title' => Yii::t('app', 'Menu Chart'),
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
    'newForm' => $newForm,
    'pagination' => $dataProvider->getPagination(),
    'afterRow' => $afterRow,
    'columns' => $columns,
]);
