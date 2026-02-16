<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model bc\models\UpsrlmFrameworkValidationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="upsrlm-framework-validation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'key_id') ?>

    <?= $form->field($model, 'deliverables_id') ?>

    <?= $form->field($model, 'start_date') ?>

    <?= $form->field($model, 'operational_stage') ?>

    <?php // echo $form->field($model, 'current_status') ?>

    <?php // echo $form->field($model, 'validation_by') ?>

    <?php // echo $form->field($model, 'validation_status') ?>

    <?php // echo $form->field($model, 'validation_datetime') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
