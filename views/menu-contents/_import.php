<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MenuContent */
/* @var $form yii\widgets\ActiveForm */

$form = ActiveForm::begin([
    'options' => ['data-pjax' => true],
    'action' => Url::current(['parent_id' => $parentModel->id, 'state' => 'import',]),
    'fieldConfig' => [
        'template' => '<div class="input-group w-100">{label}{input}</div>{hint}{error}',
        'labelOptions' => [
            'class' => 'input-group-addon',
        ],
    ]
]);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'content')->label(false)->textarea() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <?= Html::submitButton('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Import'), ['class' => 'btn btn-block btn-social btn-success']); ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>