<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ApplicationData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-data-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-4"?>
            <?= $form->field($model, 'bc_identify')->textInput() ?>

            <?= $form->field($model, 'bc_preselect')->textInput() ?>
        </div>
        <div class="col-lg-4"?>
            <?= $form->field($model, 'bc_trained')->textInput() ?>
            <?= $form->field($model, 'bc_trained_and_certified')->textInput() ?>

        </div>
        <div class="col-lg-4"?>

            <?= $form->field($model, 'bc_onboarded')->textInput() ?>

            <?= $form->field($model, 'bc_operational')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4"?>
            <?= $form->field($model, 'clf_formed')->textInput() ?>
            <?= $form->field($model, 'clf_e_registered')->textInput() ?>
            <?= $form->field($model, 'clf_app_operated')->textInput() ?>
            <?= $form->field($model, 'clf_stagnant_fund')->textInput() ?>
        </div>
        <div class="col-lg-4"?>
            <?= $form->field($model, 'clf_start_up_received')->textInput() ?>
            <?= $form->field($model, 'clf_cif_received')->textInput() ?>

            <?= $form->field($model, 'clf_isf_received')->textInput() ?>

        </div>
        <div class="col-lg-4"?>
            <?= $form->field($model, 'clf_infra_fund_received')->textInput() ?>

            <?= $form->field($model, 'clf_others_fund_received')->textInput() ?>

            <?= $form->field($model, 'clf_fund_utilization_efficiency')->textInput() ?>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-4"?>
            <?= $form->field($model, 'vo_formed')->textInput() ?>

            <?= $form->field($model, 'vo_e_registered')->textInput() ?>

            <?= $form->field($model, 'vo_app_operated')->textInput() ?>
        </div>
        <div class="col-lg-4"?>
            <?= $form->field($model, 'vo_start_up_received')->textInput() ?>

            <?= $form->field($model, 'vo_vrf_received')->textInput() ?>

            <?= $form->field($model, 'vo_lf_received')->textInput() ?>

        </div>
        <div class="col-lg-4"?>
            <?= $form->field($model, 'vo_patb_received')->textInput() ?>

            <?= $form->field($model, 'vo_agey_received')->textInput() ?>

            <?= $form->field($model, 'vo_isf_received')->textInput() ?>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-4"?>
            <?= $form->field($model, 'shg_formed')->textInput() ?>

            <?= $form->field($model, 'shg_e_registered')->textInput() ?>

            <?= $form->field($model, 'shg_members')->textInput() ?>
            <?= $form->field($model, 'shg_stagnant_fund')->textInput() ?>
        </div>
        <div class="col-lg-4"?>
            <?= $form->field($model, 'shg_start_up_received')->textInput() ?>

            <?= $form->field($model, 'shg_cif_received')->textInput() ?>

            <?= $form->field($model, 'shg_repeated_bank_loan')->textInput() ?>

        </div>
        <div class="col-lg-4"?>
            <?= $form->field($model, 'shg_fund_3_received')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'shg_fund_4_received')->textInput() ?>

            <?= $form->field($model, 'shg_fund_utilization_efficiency')->textInput() ?>



        </div>
    </div>
    <div class="row">
        <div class="col-lg-4"?>
            <?= $form->field($model, 'ga_total_users')->textInput() ?>
        </div>
        <div class="col-lg-4"?>
            <?= $form->field($model, 'ga_total_pageviews')->textInput() ?>

        </div>
        <div class="col-lg-4"?>
            <?= $form->field($model, 'ga_last_updated_on')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
