<?php

use yii\helpers\Html;

$columns = [
    'id',
    'title',
    [
        'attribute' => 'grid_where_like',
        'value' => function ($dataProviderModel) use ($parentModel) {
            return $dataProviderModel::getMenuGridWhereLikesTitle($dataProviderModel->grid_where_like);
        },
    ],
    [
        'attribute' => 'submenu',
        'value' => function ($dataProviderModel) {
            return $dataProviderModel->getHeaderTitle($dataProviderModel->submenu);
        },
    ],
    [
        'value' => function ($dataProviderModel) use ($model, $state) {
            if ($dataProviderModel) {
                return Html::a(Yii::t('app', 'Menu Content'), ['menu-contents/index', 'parent_id' => $dataProviderModel->id], ['class' => 'btn btn-block btn-default', 'data-pjax' => 0]);
            }
        },
        'format' => 'raw',
    ],
    [
        'value' => function ($dataProviderModel) use ($model, $state) {
            if ($dataProviderModel) {
                return Html::a(Yii::t('app', 'Menu Chart'), ['menu-charts/index', 'parent_id' => $dataProviderModel->id], ['class' => 'btn btn-block btn-default', 'data-pjax' => 0]);
            }
        },
        'format' => 'raw',
    ],
    [
        'value' => function ($dataProviderModel) use ($model, $state) {
            if ($dataProviderModel) {
                return Html::a(Yii::t('app', 'Menu Visits'), ['menu-visits/index', 'parent_id' => $dataProviderModel->id], ['class' => 'btn btn-block btn-default', 'data-pjax' => 0]);
            }
        },
        'format' => 'raw',
    ],
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
    echo $this->render('../menus/_form', [
        'model' => $dataProviderModel,
        'parentModel' => $parentModel,
    ]);
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
    echo $this->render('../menus/_form', [
        'model' => $newModel,
        'parentModel' => $parentModel,
    ]);
    $formContent = ob_get_contents();
    ob_end_clean();

    return $formContent;
};

echo $this->render('/layouts/grid', [
    'title' => Yii::t('app', 'Menus'),
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
    'newForm' => $newForm,
    'pagination' => $dataProvider->getPagination(),
    'afterRow' => $afterRow,
    'columns' => $columns,
]);
