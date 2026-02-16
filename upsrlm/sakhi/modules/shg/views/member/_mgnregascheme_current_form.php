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
<script>
    function takePictureJobcard(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDatajobcard(data) {
        document.getElementById('job-card-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('dbtbeneficiaryschememgnregaform-current_job_card_photo').setAttribute('value', data);

    }
</script>
<?php $form = ActiveMobileForm::begin(['id' => 'form-shgmember', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">
    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "current_mgnrega_beneficiary")->radioList($model->yesnooption)->label($model->getAttributeLabel('current_mgnrega_beneficiary')) ?>
    </div>

    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "current_mgnrega_beneficiary_interested_work")->radioList($model->yesnooption)->label($model->getAttributeLabel('current_mgnrega_beneficiary_interested_work')) ?>
    </div>
    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "current_mgnrega_beneficiary_day")->radioList($model->work_day_option)->label($model->getAttributeLabel('current_mgnrega_beneficiary_day')) ?>
    </div>
    <div class="col-lg-12 field-dbtbeneficiaryschememgnregaform-current_job_card_photo">
        <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePictureJobcard('imageDatajobcard')">
            <i class="fal fa-camera"></i> 4. कृपया अपने जॉब कार्ड का सीधा और स्पष्ट फोटो अपलोड करें
        </button>
        <?= $form->field($model, 'current_job_card_photo')->hiddenInput([])->label('') ?>
        <img id="job-card-image" src="" class="img-responsive" width="200" height="300" />
    </div>
</div>
<div class="form-group text-center">
    <?= Html::submitButton('सेव करें और आगे बढ़ें', ['class' => 'btn btn-sm btn-info form-control mt-2', 'name' => 'save_b', 'id' => 'save_b']) ?>
    <?= $form->field($model, 'dbt_beneficiary_household_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'rishta_shg_member_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'dbt_beneficiary_scheme_mgnrega_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'scenario')->hiddenInput()->label(false); ?>
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
<?php
$js = <<<JS
   $(document).ready(function() {
       $(".field-dbtbeneficiaryschememgnregaform-current_mgnrega_beneficiary_interested_work").css("display","none");
       $(".field-dbtbeneficiaryschememgnregaform-current_mgnrega_beneficiary_day").css("display","none");
       $(".field-dbtbeneficiaryschememgnregaform-current_job_card_photo").css("display","none");
   $("#dbtbeneficiaryschememgnregaform-current_mgnrega_beneficiary").on("change", function() {
        selectded_value = $("input[type='radio'][name='DbtBeneficiarySchemeMgnregaForm[current_mgnrega_beneficiary]']:checked").val();
       if (selectded_value == 1) {
            $(".field-dbtbeneficiaryschememgnregaform-current_job_card_photo").css("display","block");
            $(".field-dbtbeneficiaryschememgnregaform-current_mgnrega_beneficiary_interested_work").css("display","block");
            $(".field-dbtbeneficiaryschememgnregaform-current_mgnrega_beneficiary_day").css("display","none");
            selectded_value1 = $("input[type='radio'][name='DbtBeneficiarySchemeMgnregaForm[current_mgnrega_beneficiary_interested_work]']:checked").val();
            if(selectded_value1==1){
            $(".field-dbtbeneficiaryschememgnregaform-current_mgnrega_beneficiary_day").css("display","block");
             }
            
        }else{
            $(".field-dbtbeneficiaryschememgnregaform-current_job_card_photo").css("display","none");
            $(".field-dbtbeneficiaryschememgnregaform-current_mgnrega_beneficiary_interested_work").css("display","block");
            $('input[name="DbtBeneficiarySchemeMgnregaForm[current_job_card_photo]"]').prop("checked", false);
            $('input[name="DbtBeneficiarySchemeMgnregaForm[current_mgnrega_beneficiary_day]"]').prop("checked", false);
        }
    }); 
    

    $("#dbtbeneficiaryschememgnregaform-current_mgnrega_beneficiary_interested_work").on("change", function() {
        selectded_value = $("input[type='radio'][name='DbtBeneficiarySchemeMgnregaForm[current_mgnrega_beneficiary_interested_work]']:checked").val();
       if (selectded_value == 1) {
            $(".field-dbtbeneficiaryschememgnregaform-current_mgnrega_beneficiary_day").css("display","block");
        }else{
            $(".field-dbtbeneficiaryschememgnregaform-current_mgnrega_beneficiary_day").css("display","none");
            $('input[name="DbtBeneficiarySchemeMgnregaForm[current_mgnrega_beneficiary_day]"]').prop("checked", false);
        }
    }); 
   
   });         
JS;
$this->registerJs($js);
?>