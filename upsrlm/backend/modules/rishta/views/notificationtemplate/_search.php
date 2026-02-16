<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model bc\models\NotificationTemplateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-template-search">

    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
    ]);
    ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'acknowledge')->radioList([1 => 'yes', 0 => 'No'])->label('Acknowledge'); ?>
    <?= $form->field($model, 'visible')->radioList([1 => 'yes', 0 => 'No'])->label('Visible'); ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
