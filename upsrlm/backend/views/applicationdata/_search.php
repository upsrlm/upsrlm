<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ApplicationDataSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'bc_identify') ?>

    <?= $form->field($model, 'bc_preselect') ?>

    <?= $form->field($model, 'bc_trained') ?>

    <?= $form->field($model, 'bc_trained_and_certified') ?>

    <?php // echo $form->field($model, 'bc_onboarded') ?>

    <?php // echo $form->field($model, 'bc_operational') ?>

    <?php // echo $form->field($model, 'clf_formed') ?>

    <?php // echo $form->field($model, 'clf_e_registered') ?>

    <?php // echo $form->field($model, 'clf_app_operated') ?>

    <?php // echo $form->field($model, 'clf_start_up_received') ?>

    <?php // echo $form->field($model, 'clf_cif_received') ?>

    <?php // echo $form->field($model, 'clf_isf_received') ?>

    <?php // echo $form->field($model, 'clf_infra_fund_received') ?>

    <?php // echo $form->field($model, 'clf_others_fund_received') ?>

    <?php // echo $form->field($model, 'clf_fund_utilization_efficiency') ?>

    <?php // echo $form->field($model, 'clf_stagnant_fund') ?>

    <?php // echo $form->field($model, 'vo_formed') ?>

    <?php // echo $form->field($model, 'vo_e_registered') ?>

    <?php // echo $form->field($model, 'vo_app_operated') ?>

    <?php // echo $form->field($model, 'vo_start_up_received') ?>

    <?php // echo $form->field($model, 'vo_vrf_received') ?>

    <?php // echo $form->field($model, 'vo_lf_received') ?>

    <?php // echo $form->field($model, 'vo_patb_received') ?>

    <?php // echo $form->field($model, 'vo_agey_received') ?>

    <?php // echo $form->field($model, 'vo_isf_received') ?>

    <?php // echo $form->field($model, 'shg_formed') ?>

    <?php // echo $form->field($model, 'shg_e_registered') ?>

    <?php // echo $form->field($model, 'shg_members') ?>

    <?php // echo $form->field($model, 'shg_start_up_received') ?>

    <?php // echo $form->field($model, 'shg_cif_received') ?>

    <?php // echo $form->field($model, 'shg_repeated_bank_loan') ?>

    <?php // echo $form->field($model, 'shg_fund_3_received') ?>

    <?php // echo $form->field($model, 'shg_fund_4_received') ?>

    <?php // echo $form->field($model, 'shg_fund_utilization_efficiency') ?>

    <?php // echo $form->field($model, 'shg_stagnant_fund') ?>

    <?php // echo $form->field($model, 'ga_total_users') ?>

    <?php // echo $form->field($model, 'ga_total_pageviews') ?>

    <?php // echo $form->field($model, 'ga_last_updated_on') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
