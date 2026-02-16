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
            'id' => 'fd4-section',
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
            <?php if ($model->fd_section_qno == '501') { ?>   
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec4_can_you_do_mobile_banking_service', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->sec4_can_you_do_mobile_banking_service_option, $option)->label("4.1 क्या आप मोबाइल से बैंकिंग सेवा कर पाते हैं? <button asrc='/images/audio/assessment/pre/e_finance_5/e-finance 4.1.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>  
                    </div>
                </div>
            <?php } ?> 
            <?php if ($model->fd_section_qno == '502') { ?>   
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec4_avg_visit_bank_atm_in_month', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->sec4_avg_visit_bank_atm_in_month_option, $option)->label("4.2 औसतन एक माह में आपको कितनी बार बैंक/ एटीएम जाना पड़ता है <button asrc='/images/audio/assessment/pre/e_finance_5/e-finance 4.2.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>  
                    </div>
                </div>
            <?php } ?> 
            <?php if ($model->fd_section_qno == '503') { ?> 
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec4_easy_access_to_banking_services', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->sec4_easy_access_to_banking_services_option, $option)->label("4.3 क्या आपको बैंक जाने पर भी, बैंकिंग सेवाएँ सुलभ उपलब्ध हो पाती है <button asrc='/images/audio/assessment/pre/e_finance_5/e-finance 4.3.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>  
                    </div>
                </div>
            <?php } ?> 
            <?php if ($model->fd_section_qno == '504') { ?> 
                <div class='card'>
                    <div class="col-lg-12"> 
                        <?php
                        echo Html::activeLabel($model, "sec4_44_lable", ['class' => 'bold_lable'])." <button asrc='/images/audio/assessment/pre/e_finance_5/e-finance 4.4.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>";
                        ?>

                        <?=
                        $form->field($model, 'sec4_loan_application', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_noidea_option)
                        ?>
                        <?=
                        $form->field($model, 'sec4_Intimation_debt_any_other_receipt', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_noidea_option)
                        ?>
                        <?=
                        $form->field($model, 'sec4_step_wise_information_financial_process_bank', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_noidea_option)
                        ?>
                        <?=
                        $form->field($model, 'sec4_transaction_details_bank_account', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_noidea_option)
                        ?>
                        <?=
                        $form->field($model, 'sec4_insurance_application', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_noidea_option)
                        ?>
                        <?=
                        $form->field($model, 'sec4_all_payments_made_by_you', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_noidea_option)
                        ?>
                        <?=
                        $form->field($model, 'sec4_schemes_benefits_updates', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_noidea_option)
                        ?>
                        <?=
                        $form->field($model, 'sec4_buy_sell_on_ecommerce_platform', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_noidea_option)
                        ?>
                        <?=
                        $form->field($model, 'sec4_knowledge_financial_literacy_money_management', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_noidea_option)
                        ?>

                    </div>
                </div>
            <?php } ?> 
            <?php if ($model->fd_section_qno == '505') { ?> 
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'sec4_bc_sakhi_gram_panchayat', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->radioList($model->yes_no_option, $option)->label("4.5 क्या आपके ग्राम पंचायत में बीसी सखी हैं? <button asrc='/images/audio/assessment/pre/e_finance_5/e-finance 4.5, 4.6, 4.7.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                    ?>  
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'sec4_yes_bc_sakhi_gram_panchayat', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->radioList($model->yes_no_option, $option);
                    ?>  
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'sec4_transaction_failure_bc_sakhi', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->radioList($model->yes_no_option, $option);
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
 <?php if ($model->fd_section_qno == '505') { ?> 
<?php
$js = <<<JS
    $(document).ready(function() {
        
         $(".field-fbdemandsideform-sec4_yes_bc_sakhi_gram_panchayat").css("display","none");
         $(".field-fbdemandsideform-sec4_transaction_failure_bc_sakhi").css("display","none");
         $('input[type=radio][name="FbdemandsideForm[sec4_bc_sakhi_gram_panchayat]"]').change(function() {
        if($(this).val()=='1') {
           $(".field-fbdemandsideform-sec4_yes_bc_sakhi_gram_panchayat").css("display","block");
           
        } else{
           $(".field-fbdemandsideform-sec4_yes_bc_sakhi_gram_panchayat").css("display","none");
            $(".field-fbdemandsideform-sec4_transaction_failure_bc_sakhi").css("display","none");
         $('input[name="FbdemandsideForm[sec4_yes_bc_sakhi_gram_panchayat]"]').prop('checked', false);
        }
       });
         if($('input[type=radio][name="FbdemandsideForm[sec4_bc_sakhi_gram_panchayat]"]:checked').val()=='1'){
            $(".field-fbdemandsideform-sec4_yes_bc_sakhi_gram_panchayat").css("display","block");
         }  
        
         $('input[type=radio][name="FbdemandsideForm[sec4_yes_bc_sakhi_gram_panchayat]"]').change(function() {
        if($(this).val()=='1') {
          $(".field-fbdemandsideform-sec4_transaction_failure_bc_sakhi").css("display","block");
        } else{
          $(".field-fbdemandsideform-sec4_transaction_failure_bc_sakhi").css("display","none");
          $('input[name="FbdemandsideForm[sec4_transaction_failure_bc_sakhi]"]').prop('checked', false);
        }
        
        
    });
        
    });         
JS;
$this->registerJs($js);
?>
<?php } ?>