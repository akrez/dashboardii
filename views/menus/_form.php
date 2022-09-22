<?php

use app\models\Menu;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 *
 * @var Menu $model
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
        <div class="col-sm-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'grid_where_like')->dropDownList($model->getMenuGridWhereLikesList()) ?>
        </div>
        <?php if ($model->getHeadersList()) { ?>
            <div class="col-sm-4">
                <?= $form->field($model, 'submenu')->dropDownList($model->getHeadersList(), [
                    'prompt' => [
                        'text' => '',
                        'options' => [
                            'value' => null,
                        ],
                    ],
                ]) ?>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <?= Html::submitButton($model->isNewRecord ? ' <span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Create') : ' <span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('app', 'Update'), ['class' => 'btn btn-block btn-social ' . ($model->isNewRecord ? 'btn-success' : 'btn-primary')]); ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>