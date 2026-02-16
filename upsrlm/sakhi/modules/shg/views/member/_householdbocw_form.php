<?php

use yii\helpers\Html;
use sakhi\widgets\ActiveMobileForm;
?>
<?php
$form = ActiveMobileForm::begin([
            'id' => 'form-shgmember', 'enableAjaxValidation' => true, 'enableClientValidation' => false,
//            'action' => $action_url,
            'options' => ['enctype' => 'multipart/form-data']
        ]);
?>
<div class='card'>
    <div class="row">

        <div class="col-lg-6 mb-2">
            <?php echo $form->field($model, "bocw_reg_no")->textInput() ?>
        </div>
    </div>
</div>
<div class="form-group text-center">

    <?= $form->field($model, 'dbt_beneficiary_household_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'rishta_shg_member_id')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label(false); ?>


    <?= Html::submitButton('सेव', ['class' => 'btn btn-sm btn-info form-control mt-2', 'name' => 'save_b', 'id' => 'save_b']) ?>
</div>
<?php ActiveMobileForm::end(); ?>
