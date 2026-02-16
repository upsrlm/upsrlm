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
            'id' => 'fd-section',
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
            <?php if ($model->fd_section_qno == '201') { ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec1_use_any_elearning_app_portal', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option, $option)->label("1.1 क्या आपके परिवार के छात्र/ छात्रायें कोई ई-लर्निंग ऐप या पोर्टल का उपयोग करते हैं? <button asrc='/images/audio/assessment/pre/e-shiksha_2/e-shiksha 1.1, 1.2,1.3.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>  
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec1_yes_which_elearning_product_use', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->textInput();
                        ?>
                        <?=
                        $form->field($model, 'sec1_how_much_annual_subscription', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->textInput(['type' => 'number', 'min' => 0, 'max' => 5000]);
                        ?> 
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec1_if_not_why', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->sec1_if_not_why_option, $option);
                        ?>  
                    </div>
                </div>
            <?php } ?>
            <?php if ($model->fd_section_qno == '202') { ?>  
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'sec1_whether_school_teachers_using_elearning_product', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->radioList($model->yes_no_option, $option)->label("1.4 क्या विद्यालय/ शिक्षकों ने कोई ई-शिक्षण (ऐप के माध्यम से पढ़ाने की व्यवस्था) का उत्पाद का उपयोग कर रहें हैं <button asrc='/images/audio/assessment/pre/e-shiksha_2/e-shiksha 1.4, 1.5, 1.6.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                    ?>  
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'sec1_yes_whether_school_teachers_using_elearning_product_name', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->textInput();
                    ?>
                    <?=
                    $form->field($model, 'sec1_yes_whether_school_teachers_using_elearning_product_subscri', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->textInput(['type' => 'number', 'min' => 0, 'max' => 5000]);
                    ?> 
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'sec1_no_whether_school_teachers_using_elearning_product', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->radioList($model->sec1_no_whether_school_teachers_using_elearning_product_option, $option);
                    ?>  
                </div>
            </div>
            <?php } ?>
            <?php if ($model->fd_section_qno == '203') { ?>  
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'sec1_elearning_facility_improve_education', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->radioList($model->sec1_elearning_facility_improve_education_option, $option)->label("1.7 छात्रों के शिक्षा में विशेष सुधार हो सके ऐसी कोई ई-लर्निंग की सुविधा हो तो क्या आप के लिये लाभदायी होगी? <button asrc='/images/audio/assessment/pre/e-shiksha_2/e-shiksha 1.7, 1.8.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                    ?>  
                </div>
            </div>
             
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'sec1_yes_elearning_facility_improve_education_min_cost', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->radioList($model->sec1_yes_elearning_facility_improve_education_min_cost_option, $option);
                    ?>  
                </div>
            </div>
            <?php } ?>
            <?php if ($model->fd_section_qno == '204') { ?> 
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'sec1_part_of_cost_borne_by_government', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->radioList($model->sec1_part_of_cost_borne_by_government_option, $option)->label("1.9 क्या ऐसी किसी सुविधा पर होने वाले खर्च का एक भाग सरकार द्वारा वहन किया जाना चाहिए? <button asrc='/images/audio/assessment/pre/e-shiksha_2/e-shiksha 1.9.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
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
<?php
$js = <<<JS
    $(document).ready(function() {
        
        $(".field-fbdemandsideform-sec1_yes_which_elearning_product_use").css("display","none");
        $(".field-fbdemandsideform-sec1_how_much_annual_subscription").css("display","none");
        $(".field-fbdemandsideform-sec1_if_not_why").css("display","none");
        $(".field-fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_name").css("display","none");
        $(".field-fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_subscri").css("display","none");
        $(".field-fbdemandsideform-sec1_no_whether_school_teachers_using_elearning_product").css("display","none");
        $(".field-fbdemandsideform-sec1_yes_elearning_facility_improve_education_min_cost").css("display","none");
         $('input[type=radio][name="FbdemandsideForm[sec1_use_any_elearning_app_portal]"]').change(function() {
        if($(this).val()=='1') {
        $(".field-fbdemandsideform-sec1_how_much_annual_subscription").css("display","block");
        $(".field-fbdemandsideform-sec1_yes_which_elearning_product_use").css("display","block");
        $(".field-fbdemandsideform-sec1_if_not_why").css("display","none");
        $('input[name="FbdemandsideForm[sec1_if_not_why]"]').prop('checked', false);
        } else if ($(this).val()=='2') {
            $(".field-fbdemandsideform-sec1_yes_which_elearning_product_use").css("display","none");
            $(".field-fbdemandsideform-sec1_how_much_annual_subscription").css("display","none");
            $("#fbdemandsideform-sec1_yes_which_elearning_product_use").val('');
            $("#fbdemandsideform-sec1_how_much_annual_subscription").val('');
            $(".field-fbdemandsideform-sec1_if_not_why").css("display","block");
        } else{
        $(".field-fbdemandsideform-sec1_yes_which_elearning_product_use").css("display","none");
        $(".field-fbdemandsideform-sec1_how_much_annual_subscription").css("display","none");
        $("#fbdemandsideform-sec1_yes_which_elearning_product_use").val('');
        $("#fbdemandsideform-sec1_how_much_annual_subscription").val('');
        $(".field-fbdemandsideform-sec1_if_not_why").css("display","none");
         $('input[name="FbdemandsideForm[sec1_if_not_why]"]').prop('checked', false);
        }
    });
         if($('input[type=radio][name="FbdemandsideForm[sec1_use_any_elearning_app_portal]"]:checked').val()=='1'){
             $(".field-fbdemandsideform-sec1_how_much_annual_subscription").css("display","block");
             $(".field-fbdemandsideform-sec1_yes_which_elearning_product_use").css("display","block");
             $(".field-fbdemandsideform-sec1_if_not_why").css("display","none");
              $('input[name="FbdemandsideForm[sec1_if_not_why]"]').prop('checked', false);
        }  

         if($('input[type=radio][name="FbdemandsideForm[sec1_use_any_elearning_app_portal]"]:checked').val()=='2'){
            $(".field-fbdemandsideform-sec1_yes_which_elearning_product_use").css("display","none");
            $(".field-fbdemandsideform-sec1_how_much_annual_subscription").css("display","none");
            $(".field-fbdemandsideform-sec1_if_not_why").css("display","block");
            $("#fbdemandsideform-sec1_yes_which_elearning_product_use").val('');
            $("#fbdemandsideform-sec1_how_much_annual_subscription").val('');
        }
        
         $('input[type=radio][name="FbdemandsideForm[sec1_whether_school_teachers_using_elearning_product]"]').change(function() {
        if($(this).val()=='1') {
        $(".field-fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_name").css("display","block");
        $(".field-fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_subscri").css("display","block");
        $(".field-fbdemandsideform-sec1_no_whether_school_teachers_using_elearning_product").css("display","none");
        $('input[name="FbdemandsideForm[sec1_no_whether_school_teachers_using_elearning_product]"]').prop('checked', false);
        } else if ($(this).val()=='2') {
            $(".field-fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_name").css("display","none");
            $(".field-fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_subscri").css("display","none");
            $("#fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_name").val('');
            $("#fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_subscri").val('');
            $(".field-fbdemandsideform-sec1_no_whether_school_teachers_using_elearning_product").css("display","block");
        } else{
        $(".field-fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_name").css("display","none");
        $(".field-fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_subscri").css("display","none");
        $("#fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_name").val('');
        $("#fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_subscri").val('');
        $(".field-fbdemandsideform-sec1_no_whether_school_teachers_using_elearning_product").css("display","none");
         $('input[name="FbdemandsideForm[sec1_no_whether_school_teachers_using_elearning_product]"]').prop('checked', false);
        }
        
        if($('input[type=radio][name="FbdemandsideForm[sec1_whether_school_teachers_using_elearning_product]"]:checked').val()=='1'){
             $(".field-fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_name").css("display","block");
             $(".field-fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_subscri").css("display","block");
             $(".field-fbdemandsideform-sec1_no_whether_school_teachers_using_elearning_product").css("display","none");
             $('input[name="FbdemandsideForm[sec1_no_whether_school_teachers_using_elearning_product]"]').prop('checked', false);
        }  

         if($('input[type=radio][name="FbdemandsideForm[sec1_whether_school_teachers_using_elearning_product]"]:checked').val()=='2'){
            $(".field-fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_name").css("display","none");
            $(".field-fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_subscri").css("display","none");
            $("#fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_name").val('');
            $("#fbdemandsideform-sec1_yes_whether_school_teachers_using_elearning_product_subscri").val('');
            $(".field-fbdemandsideform-sec1_no_whether_school_teachers_using_elearning_product").css("display","block");
        }
        
    });
        
        $('input[type=radio][name="FbdemandsideForm[sec1_elearning_facility_improve_education]"]').change(function() {
        if($(this).val()=='1') {
         $(".field-fbdemandsideform-sec1_yes_elearning_facility_improve_education_min_cost").css("display","block");
        }  else{
        $(".field-fbdemandsideform-sec1_yes_elearning_facility_improve_education_min_cost").css("display","none");
         $('input[name="FbdemandsideForm[sec1_yes_elearning_facility_improve_education_min_cost]"]').prop('checked', false);
        }
    });
     if($('input[type=radio][name="FbdemandsideForm[sec1_elearning_facility_improve_education]"]:checked').val()=='1'){
             $(".field-fbdemandsideform-sec1_yes_elearning_facility_improve_education_min_cost").css("display","block");
        }     
    });         
JS;
$this->registerJs($js);
?>
