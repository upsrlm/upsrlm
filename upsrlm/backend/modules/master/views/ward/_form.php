<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\master\MasterWard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-ward-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'division_code')->textInput() ?>

    <?= $form->field($model, 'division_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'district_code')->textInput() ?>

    <?= $form->field($model, 'district_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sub_district_code')->textInput() ?>

    <?= $form->field($model, 'sub_district_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ulb_code')->textInput() ?>

    <?= $form->field($model, 'ulb_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ward_code')->textInput() ?>

    <?= $form->field($model, 'ward_number')->textInput() ?>

    <?= $form->field($model, 'ward_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
