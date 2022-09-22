<?php

$columns = [];
foreach ($parentModel->getHeadersList() as $columnName => $columnLabel) {
    $columns[] = [
        'label' => $columnLabel,
        'attribute' => $columnName,
    ];
}
$afterRow = null;
$newForm = function () use ($newModel, $parentModel) {
    ob_start();
    echo  $this->render('../menu-contents/_import', [
        'model' => $newModel,
        'parentModel' => $parentModel,
    ]);
    $formContent = ob_get_contents();
    ob_end_clean();

    return $formContent;
};

echo $this->render('/layouts/grid', [
    'title' => Yii::t('app', 'Menu Content'),
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
    'newForm' => $newForm,
    'pagination' => $dataProvider->getPagination(),
    'afterRow' => $afterRow,
    'columns' => $columns,
]);
