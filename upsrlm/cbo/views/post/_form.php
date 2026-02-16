<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CboVo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cbo-vo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'division_code')->textInput() ?>

    <?= $form->field($model, 'division_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'district_code')->textInput() ?>

    <?= $form->field($model, 'district_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'block_code')->textInput() ?>

    <?= $form->field($model, 'block_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gram_panchayat_code')->textInput() ?>

    <?= $form->field($model, 'gram_panchayat_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_of_vo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_formation')->textInput() ?>

    <?= $form->field($model, 'no_of_shg_connected')->textInput() ?>

    <?= $form->field($model, 'bank_account_no_of_the_vo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_of_bank')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'branch')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'branch_code_or_ifsc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_opening_the_bank_account')->textInput() ?>

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
