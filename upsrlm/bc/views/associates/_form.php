<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model bc\models\PartnerAssociates */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="partner-associates-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'master_bank_id')->textInput() ?>

    <?= $form->field($model, 'name_of_the_field_officer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput() ?>

    <?= $form->field($model, 'date_of_birth')->textInput() ?>

    <?= $form->field($model, 'age')->textInput() ?>

    <?= $form->field($model, 'photo_profile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'designation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alternate_mobile_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'whatsapp_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photo_aadhaar_front')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photo_aadhaar_back')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_letter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_of_supervisor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'designation_of_supervisor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile_no_of_supervisor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_branch')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_ifsc_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_account_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
