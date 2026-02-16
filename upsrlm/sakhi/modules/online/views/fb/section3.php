<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = $name;
$app = new \sakhi\components\App();
$option = [];
?>
<?php
$form = ActiveMobileForm::begin([
            'id' => 'fd2-section',
            'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
        ]);
?>
<div class='card'>
<div class="col-lg-12">
    <div class="text-center"> 
        <h3>
            <?= $this->title ?>
        </h3>
    </div>
</div>
    <div class="col-lg-12">

        <div class='card-body'>
            <?php if ($model->fd_section_qno == '301') { ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec2_know_tele_medicine_through_live_video', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option, $option)->label("2.1 क्या आप को लाइव वीडियो के माध्यम से चिकित्सा पद्धति (टेली-मेडिसिन) के बारे में जानकारी हैं? <button asrc='/images/audio/assessment/pre/e_swasthya_3/e-swasthya 2.1, 2.2.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>  
                    </div>
                </div>


                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec2_yes_used_tele_medicine_medium', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option, $option);
                        ?>  
                    </div>
                </div>  
            <?php } ?>
            <?php if ($model->fd_section_qno == '302') { ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec2_know_effective_treatment_through_tele_medicine', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option, $option)->label("2.3 क्या आपको जानकारी है टेली-मेडिसिन के माध्यम से डाक्टरी सलाह तथा चिकित्सा कितना प्रभावी होता है <button asrc='/images/audio/assessment/pre/e_swasthya_3/e-swasthya 2.3.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>  
                    </div>
                </div>
            <?php } ?>
            <?php if ($model->fd_section_qno == '303') { ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec2_aware_cost_medical_consultation_through_tele_medicine', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option, $option)->label("2.4 क्या आपको टेली-मेडिसिन के माध्यम से डाक्टरी सलाह तथा चिकित्सा पर होने वाले ख़र्चों के बारे में जानकारी है <button asrc='/images/audio/assessment/pre/e_swasthya_3/e-swasthya 2.4.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>  
                    </div>
                </div>
            <?php } ?>
            <?php if ($model->fd_section_qno == '304') { ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec2_explain_understanding_tele_medicine', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->checkboxList($model->sec2_explain_understanding_tele_medicine_option)->label("2.5 टेली-मेडिसिन के बारे में अपनी समझ स्पष्ट करें (एक से ज़्यादा उत्तर में टिक कर सकते हैं) <button asrc='/images/audio/assessment/pre/e_swasthya_3/e-swasthya 2.5.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>
                    </div>
                </div>
            <?php } ?>
            <?php if ($model->fd_section_qno == '305') { ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec2_strong_system_telemedicine_maximum_fee', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->sec2_strong_system_telemedicine_maximum_fee_option, $option)->label("2.6 अगर ग्रामीणों के लिए टेली मेडिसिन का सुदृढ़ व्यवस्था की जाये तो उनके लिये अधिकतम कितनी फ़ीस होनी चाहिए <button asrc='/images/audio/assessment/pre/e_swasthya_3/e-swasthya 2.6.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>  
                    </div>
                </div>
            <?php } ?>
            <?php if ($model->fd_section_qno == '306') { ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec2_subsidy_by_government', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->sec2_subsidy_by_government_option, $option)->label("2.7 सब्सिडी: क्या ऐसी किसी सुविधा पर होने वाले खर्च का एक भाग सरकार द्वारा वहन किया जाना चाहिए? <button asrc='/images/audio/assessment/pre/e_swasthya_3/e-swasthya 2.7.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>  
                    </div>
                </div>
            <?php } ?>
            <div class="form-group text-center">
                <div style="display: none">
                    <?= $form->field($model, 'fd_section_qno')->hiddenInput()->label('') ?> 
                    <?= $form->field($model, 'fd_section')->hiddenInput(['value' => $section])->label('') ?> 
                    <?= $form->field($model, 'user_id')->hiddenInput()->label('') ?>
                    <?= $form->field($model, 'id')->hiddenInput()->label('') ?>
                </div>    
                <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                <a href="<?= '/online/fb/form' ?>" class="btn btn-dark"><i class="fal fa fa-arrow-left" aria-hidden="true"></i><span> वापस</span> </a> 
            </div>     
        </div>
    </div>    
</div>  
<?php ActiveMobileForm::end(); ?>
<?php
$style1 = <<< CSS
 .card {
    margin-bottom: 5px !important;
}
.bold_lable {
  font-weight: bold !important;  
}
CSS;
$this->registerCss($style1);
?>
<?php if ($model->fd_section_qno == '301') { ?> 
<?php
$js = <<<JS
    $(document).ready(function() {
        
         $(".field-fbdemandsideform-sec2_yes_used_tele_medicine_medium").css("display","none");
         
         $('input[type=radio][name="FbdemandsideForm[sec2_know_tele_medicine_through_live_video]"]').change(function() {
        if($(this).val()=='1') {
           $(".field-fbdemandsideform-sec2_yes_used_tele_medicine_medium").css("display","block");
           
        } else{
           $(".field-fbdemandsideform-sec2_yes_used_tele_medicine_medium").css("display","none");
         $('input[name="FbdemandsideForm[sec2_yes_used_tele_medicine_medium]"]').prop('checked', false);
        }
       });
         
    });         
JS;
$this->registerJs($js);
?>
<?php } ?>