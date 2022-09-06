<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Signin');
?>

<div class="row">
    <div class="col-sm-12 col-xs-12">
    </div>
    <div class="col-sm-12 col-xs-12">
        <?php
        $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => '<div class="input-group">{label}{input}</div>{error}',
                'labelOptions' => [
                    'class' => 'input-group-addon',
                ],
            ],
        ]);
        ?>
        <?php echo $form->field($model, 'email')->textInput(); ?>
        <?php echo $form->field($model, 'password')->passwordInput(); ?>
        <?php echo $form->field($model, 'captcha', ['template' => '{input}{error}<small>{hint}</small>'])->widget(Captcha::class, [
            'template' => '<div class="text-center">{image}</div><div class="input-group">' . Html::activeLabel($model, 'captcha', ['class' => 'input-group-addon']) . '{input}</div>',
        ])->hint(Yii::t('app', 'If the captcha is illegible, click on it.')); ?>
        <?php echo $form->field($model, 'remember_me')->checkbox(); ?>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block" style="float: right;"> <?php echo Yii::t('app', 'Signin'); ?>
            </button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>