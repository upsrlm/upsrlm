<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model bc\models\UpsrlmFrameworkValidation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="upsrlm-framework-validation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'key_id')->textInput() ?>

    <?= $form->field($model, 'deliverables_id')->textInput() ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'operational_stage')->textInput() ?>

    <?= $form->field($model, 'current_status')->textInput() ?>

    <?= $form->field($model, 'validation_by')->textInput() ?>

    <?= $form->field($model, 'validation_status')->textInput() ?>

    <?= $form->field($model, 'validation_datetime')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
