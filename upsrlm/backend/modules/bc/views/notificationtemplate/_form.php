<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model bc\models\NotificationTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-template-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 2]) ?>

    <?= $form->field($model, 'template')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'acknowledge')->radioList([1 => 'yes', 0 => 'No'])->label('Acknowledge'); ?>
    <?= $form->field($model, 'visible')->radioList([1 => 'yes', 0 => 'No'])->label('Visible'); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
