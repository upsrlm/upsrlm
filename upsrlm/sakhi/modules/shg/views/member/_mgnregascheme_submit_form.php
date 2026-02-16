<?php

use yii\helpers\Html;
use sakhi\widgets\ActiveMobileForm;
use kartik\date\DatePicker;

$namopt = ['maxlength' => true];
$mobileopt = ['type' => 'number'];
$labelopt = ['class' => 'formlabel'];
// if (isset($model->dbt_member_model->id)) {
//     $namopt = ['maxlength' => true, 'readonly' => 'readonly'];
//     $mobileopt = ['readonly' => 'readonly'];
// }
?>

<?= $this->render('_mgnregascheme_view', ['model' => $model->scheme_model]) ?>
<?php $form = ActiveMobileForm::begin(['id' => 'form-shgmember', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">
    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "form_complete")->checkbox()->label($model->getAttributeLabel('form_complete')) ?>
    </div>

</div>
<div class="form-group text-center">
    <?= Html::submitButton('आवेदन पत्र जमा करें', ['class' => 'btn btn-sm btn-info form-control mt-2', 'name' => 'save_b', 'id' => 'save_b']) ?>
    <?= $form->field($model, 'dbt_beneficiary_household_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'rishta_shg_member_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'dbt_beneficiary_scheme_mgnrega_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'scenario')->hiddenInput()->label(false); ?>
    <a href="/shg/member/mgnregascheme?shgid=<?= $model->cbo_shg_id ?>&dbt_household_id=<?= $model->dbt_beneficiary_household_id ?>" class="btn btn-warning form-control mt-3"><i class="fal fa-edit"> आवेदन पत्र संपादित करें</i></a>

</div>
<?php ActiveMobileForm::end(); ?>

<?php
$style = <<< CSS
 img[src=""] {
        display: none;
    }  
    .formlabel {
        font-weight:bold;
    }

CSS;
$this->registerCss($style);
?>