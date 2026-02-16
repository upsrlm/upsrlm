<?php

use yii\helpers\Html;
use sakhi\widgets\ActiveMobileForm;
use kartik\date\DatePicker;
$this->title = 'बीओसीडब्ल्यू मांग आवेदन भरें';
$namopt = ['maxlength' => true, 'readonly' => 'readonly'];
$mobileopt = ['type' => 'number', 'readonly' => 'readonly'];
?>
<script type="text/javascript">
    var date = <?= isset($model->dob) ? strtotime($model->dob) . '000' : 0 ?>;
    var mindate = <?= date('Y-m-d', strtotime('18 years ago')) . '000' ?>;
    var maxdate = <?= time() . '000' ?>;
</script>

<script>
    
    var mindate = <?= strtotime('1980-01-01') . '000' ?>;
    var maxdate = <?= time() . '000' ?>;
</script>
<?php $form = ActiveMobileForm::begin(['id' => 'form-shgmember', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="subheader">
    <h1 class="subheader-title">
        <?= $this->title ?>
    </h1>
</div>
<div class="row">

    <div class="col-lg-6 mb-2">
        <?php echo $form->field($model, "name")->label('सदस्य का नाम')->textInput($namopt) ?>

    </div>

    <div class="col-lg-6 mb-2">
        <?php echo $form->field($model, "mobile")->textInput($mobileopt) ?>
    </div>

    <div class="col-lg-6 mb-2">
        <?php echo $form->field($model, "application_number")->textInput() ?>
    </div>
    <div class="col-lg-6 mb-2">
        <?=
        $form->field($model, 'application_date', [
            'inputTemplate' => '<div class="input-group"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fal fa-calendar-alt text-primary"></i> </span>
    </div>{input}</div>',
        ])->textInput(['placeholder' => 'आवेदन तिथि', 'onclick' => "javascript:return showCalender(date,mindate,maxdate,'dbtbeneficiaryschemebocwform-application_date');"])
        ?>
    </div>

    <div class="col-lg-6 mb-2">
        <?php echo $form->field($model, "scheme_id")->dropDownList($model->scheme_option, ['prompt' => 'चयन कीजिए']) ?>
    </div>






</div>
<div class="form-group text-center">

    <?= $form->field($model, 'dbt_beneficiary_household_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'rishta_shg_member_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'dbt_beneficiary_member_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label(false); ?>

    <?= Html::submitButton('सेव', ['class' => 'btn btn-sm btn-info form-control mt-2', 'name' => 'save_b', 'id' => 'save_b']) ?>
</div>
<?php ActiveMobileForm::end(); ?>

<?php
$style = <<< CSS
 img[src=""] {
        display: none;
    }  

CSS;
$this->registerCss($style);
?>