<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model bc\models\PartnerAssociatesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="partner-associates-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'master_bank_id') ?>

    <?= $form->field($model, 'name_of_the_field_officer') ?>

    <?= $form->field($model, 'gender') ?>

    <?= $form->field($model, 'date_of_birth') ?>

    <?php // echo $form->field($model, 'age') ?>

    <?php // echo $form->field($model, 'photo_profile') ?>

    <?php // echo $form->field($model, 'designation') ?>

    <?php // echo $form->field($model, 'mobile_no') ?>

    <?php // echo $form->field($model, 'alternate_mobile_no') ?>

    <?php // echo $form->field($model, 'whatsapp_no') ?>

    <?php // echo $form->field($model, 'email_id') ?>

    <?php // echo $form->field($model, 'photo_aadhaar_front') ?>

    <?php // echo $form->field($model, 'photo_aadhaar_back') ?>

    <?php // echo $form->field($model, 'company_letter') ?>

    <?php // echo $form->field($model, 'name_of_supervisor') ?>

    <?php // echo $form->field($model, 'designation_of_supervisor') ?>

    <?php // echo $form->field($model, 'mobile_no_of_supervisor') ?>

    <?php // echo $form->field($model, 'bank_name') ?>

    <?php // echo $form->field($model, 'bank_branch') ?>

    <?php // echo $form->field($model, 'bank_ifsc_code') ?>

    <?php // echo $form->field($model, 'bank_account_number') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
