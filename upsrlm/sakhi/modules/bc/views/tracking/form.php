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
    <div class="col-lg-12 mt-2">
        <div class="text-center"> 
            <h1>
                <?= $this->title ?>
            </h1>
        </div>
    </div>
    <div class="col-lg-12 mt-1">

        <div class='card-body'>
            <?php if (in_array($model->section, [10])) { ?> 
                <h3>आपके द्वारा इंगित किए गए समस्याओं के समाधान के लिए राज्य मिशन त्वरित कार्यवाही करेगी।</h3>
                <!--                <div class='card'>
                                    <div class="col-lg-12">  
                <?= $model->bc_feedback_model->getQues1html() ?> 
                                    </div> 
                
                                </div>
                                <div class='card'>
                
                                    <div class="col-lg-12">  
                <?= $model->bc_feedback_model->getQues2html() ?> 
                                    </div>
                
                                </div>
                                <div class='card'>
                
                                    <div class="col-lg-12">  
                <?= $model->bc_feedback_model->getQues3html() ?>
                                    </div>   
                
                                </div>
                                <div class='card'>
                
                                    <div class="col-lg-12">  
                <?= $model->bc_feedback_model->getQues4html() ?>
                                    </div>
                
                                </div>
                                <div class='card'>
                
                                    <div class="col-lg-12">  
                <?= $model->bc_feedback_model->getQues5html() ?>
                                    </div>    
                                </div>-->

            <?php } ?>
            <?php if (in_array($model->section, ['1', '2', '3', '4', '5', '6', '7','8','9'])) { ?> 

                <?php if ($model->section == '1') { ?> 
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'ques1', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->checkboxList($model->ques1_option)
                            ?>

                        </div>
                    </div>
                <?php } ?>

                <?php if ($model->section == '2') { ?> 
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'ques2', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->checkboxList($model->ques2_option)
                            ?>

                        </div>
                    </div>

                <?php } ?>
                <?php if ($model->section == '3') { ?> 
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'ques3', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->checkboxList($model->ques3_option)
                            ?>

                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->section == '4') { ?> 
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'ques4', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->checkboxList($model->ques4_option)
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->section == '5') { ?> 
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'ques5', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->checkboxList($model->ques5_option)
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->section == '6') { ?> 
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'handheld_device', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->yesno_option)
                            ?>
                        </div>
                        <div class='card handheld_device'>
                            <div class="card-header">समस्या</div>
                            <div class="col-lg-12">    
                                <?=
                                $form->field($model, 'handheld_device_ques_1', [
                                    'labelOptions' => ['class' => 'bold_lable']
                                ])->radioList($model->yesno_option)
                                ?>
                                <?=
                                $form->field($model, 'handheld_device_ques_2', [
                                    'labelOptions' => ['class' => 'bold_lable']
                                ])->radioList($model->yesno_option)
                                ?>
                                <?=
                                $form->field($model, 'handheld_device_ques_3', [
                                    'labelOptions' => ['class' => 'bold_lable']
                                ])->radioList($model->yesno_option)
                                ?>
                                <?=
                                $form->field($model, 'handheld_device_ques_4', [
                                    'labelOptions' => ['class' => 'bold_lable']
                                ])->radioList($model->yesno_option)
                                ?>
                                <?=
                                $form->field($model, 'handheld_device_ques_5', [
                                    'labelOptions' => ['class' => 'bold_lable']
                                ])->radioList($model->yesno_option)
                                ?>
                            </div>
                        </div>

                    </div>
                <?php } ?>
                <?php if ($model->section == '7') { ?> 
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'fraud_transaction', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yesno_option)
                        ?>
                    </div>
                    <div class='card fraud_transaction'>
                        <div class="card-header">समस्या</div>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'fraud_transaction_ques_1', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->yesno_option)
                            ?>
                            <?=
                            $form->field($model, 'fraud_transaction_ques_2', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->yesno_option)
                            ?>
                            <?=
                            $form->field($model, 'fraud_transaction_ques_3', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->yesno_option)
                            ?>
                            <?=
                            $form->field($model, 'fraud_transaction_ques_4', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->yesno_option)
                            ?>
                        </div>

                    </div>
                <?php } ?>
                <?php if ($model->section == '8') { ?> 
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'problems_with_bank', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yesno_option)
                        ?>
                    </div>
                    <div class='card problems_with_bank'>
                        <div class="card-header">समस्या</div>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'problems_with_bank_ques_1', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->yesno_option)
                            ?>
                            <?=
                            $form->field($model, 'problems_with_bank_ques_2', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->yesno_option)
                            ?>

                        </div>
                    </div>
                <?php } ?> 
                 <?php if ($model->section == '9') { ?> 
                    <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'bc_commissions_payment', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->yesno_option)
                            ?>
                        </div>
                    <div class='card bc_commissions_payment'>
                        <div class="card-header">समस्या</div>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'bc_commissions_payment_ques_1', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->yesno_option)
                            ?>
                            <?=
                            $form->field($model, 'bc_commissions_payment_ques_2', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->yesno_option)
                            ?>
                            <?=
                            $form->field($model, 'bc_commissions_payment_ques_3', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->yesno_option)
                            ?>

                        </div>

                    </div>
                <?php } ?> 




                <div class="form-group text-center">
                    <div style="display: none">

                        <?= $form->field($model, 'section')->hiddenInput(['value' => $section])->label('') ?> 
                        <?= $form->field($model, 'user_id')->hiddenInput()->label('') ?>
                        <?= $form->field($model, 'bc_application_id')->hiddenInput()->label('') ?>
                        <?= $form->field($model, 'srlm_bc_selection_user_id')->hiddenInput()->label('') ?>
                    </div>  
                    <?php if (in_array($section, [1, 2, 3, 4, 5, 6, 7, 8])) { ?>
                        <?= Html::submitButton('सेव करें व अगले सेक्शन पर जायें', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                    <?php } ?>
                    <?php if (in_array($section, [9])) { ?>
                        <?= Html::submitButton('सबमिट  करें', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>    
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
$style = <<< CSS
 .form-group {
  margin-bottom: 0.5rem !important;
}     
CSS;
$this->registerCss($style);
?>
<?php
$js = <<<JS
    $(document).ready(function() { 
    
    });         
JS;
$this->registerJs($js);
?>
<?php
$js = <<<JS
    $(document).ready(function() {
         $(".handheld_device").css("display","none");
         $('input[type=radio][name="BCTrackingFeedbackForm[handheld_device]"]').change(function() {
        if($(this).val()=='1') {
           $(".handheld_device").css("display","block");    
        } else{
            $(".handheld_device").css("display","none");
        }
       });
         if($('input[type=radio][name="BCTrackingFeedbackForm[handheld_device]"]:checked').val()=='1'){
           $(".handheld_device").css("display","block");  
         }  
        
    });         
JS;
$this->registerJs($js);
?>
<?php
$js = <<<JS
    $(document).ready(function() {
         $(".fraud_transaction").css("display","none");
         $('input[type=radio][name="BCTrackingFeedbackForm[fraud_transaction]"]').change(function() {
        if($(this).val()=='1') {
           $(".fraud_transaction").css("display","block");    
        } else{
            $(".fraud_transaction").css("display","none");
        }
       });
         if($('input[type=radio][name="BCTrackingFeedbackForm[fraud_transaction]"]:checked').val()=='1'){
           $(".fraud_transaction").css("display","block");  
         }  
        
    });         
JS;
$this->registerJs($js);
?>
<?php
$js = <<<JS
    $(document).ready(function() {
         $(".problems_with_bank").css("display","none");
         $('input[type=radio][name="BCTrackingFeedbackForm[problems_with_bank]"]').change(function() {
        if($(this).val()=='1') {
           $(".problems_with_bank").css("display","block");    
        } else{
            $(".problems_with_bank").css("display","none");
        }
       });
         if($('input[type=radio][name="BCTrackingFeedbackForm[problems_with_bank]"]:checked').val()=='1'){
           $(".problems_with_bank").css("display","block");  
         }  
        
    });         
JS;
$this->registerJs($js);
?>
<?php
$js = <<<JS
    $(document).ready(function() {
         $(".bc_commissions_payment").css("display","none");
         $('input[type=radio][name="BCTrackingFeedbackForm[bc_commissions_payment]"]').change(function() {
        if($(this).val()=='1') {
           $(".bc_commissions_payment").css("display","block");    
        } else{
            $(".bc_commissions_payment").css("display","none");
        }
       });
         if($('input[type=radio][name="BCTrackingFeedbackForm[bc_commissions_payment]"]:checked').val()=='1'){
           $(".bc_commissions_payment").css("display","block");  
         }  
        
    });         
JS;
$this->registerJs($js);
?>