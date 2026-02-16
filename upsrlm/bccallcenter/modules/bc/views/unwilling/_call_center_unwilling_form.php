<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;

$this->title = 'unwilling';
?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'Capturing unwilling/unreachable of BCs : ' . $model->bc_model->name ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">


                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => false,
                                'enableAjaxValidation' => TRUE,
                                'id' => 'unwilling',
                                'options' => ['id' => 'unwilling', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>
                    <?= $form->field($model, 'call_center_call_status')->radioList($model->call_center_call_status_option); ?> 
                    <div class="center_call_status_1"> 
                        <?= $form->field($model, 'rsetis_call')->radioList($model->yes_no_option); ?>  
                        <div class="rsetis_call_1">
                            <?= $form->field($model, 'express_reluctance')->radioList($model->yes_no_option); ?> 
                            <div class="express_reluctance_1">
                                <?= $form->field($model, 'unwilling_reason')->checkboxList($model->unwilling_reason_option) ?>
                            </div>    

                        </div> 
                    </div> 
                    <div class="center_call_status_2"> 
                        <?= $form->field($model, 'unwilling_reasonunreachable')->checkboxList($model->unwilling_reasonunreachable_option) ?>


                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-5 col-lg-11">
                            <?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>        
        </div>
    </div>        
</div>
<?php
$js = <<<JS
    $(document).ready(function() {
     $(".center_call_status_1").css("display","none"); 
     $(".center_call_status_2").css("display","none"); 
     $(".rsetis_call_1").css("display","none"); 
     $(".express_reluctance_1").css("display","none");    
     $('input[type=radio][name="UnwillingCallCenterForm[call_center_call_status]"]').change(function() {
         if($(this).val()==='1') {
           $(".center_call_status_1").css("display","block");
           $(".center_call_status_2").css("display","none"); 
           $('input[name="UnwillingCallCenterForm[unwilling_reasonunreachable][]"]').prop('checked', false);
           
         } 
         if($(this).val()==='2') {
           $(".center_call_status_1").css("display","none"); 
           $(".center_call_status_2").css("display","block");
           $('input[name="UnwillingCallCenterForm[rsetis_call]"]').prop('checked', false);
           $('input[name="UnwillingCallCenterForm[express_reluctance]"]').prop('checked', false);
         }     
     });
    $('input[type=radio][name="UnwillingCallCenterForm[rsetis_call]"]').change(function() {
        if($(this).val()==='1') {
          $(".rsetis_call_1").css("display","block");
        }
        if($(this).val()==='0') {
        $('input[name="UnwillingCallCenterForm[express_reluctance]"]').prop('checked', false);
         $(".rsetis_call_1").css("display","none");
        }
     }); 
     $('input[type=radio][name="UnwillingCallCenterForm[express_reluctance]"]').change(function() {
        if($(this).val()==='1') {
          $(".express_reluctance_1").css("display","block");
        }
        if($(this).val()==='0') {
        $('input[name="UnwillingCallCenterForm[unwilling_reason][]"]').prop('checked', false);
        
        $(".express_reluctance_1").css("display","none");
        }
     });      
//     var rsetis_call = $('input[name="UnwillingCallCenterForm[rsetis_call]"]:checked').val();
//        if(rsetis_call == '1')
//    {
//        $('#yes').css("display","block");
//        
//    }
//    else
//    {
//        $('#yes').css("display","none");
//        $('input[name="UnwillingCallCenterForm[express_reluctance]"]').prop('checked', false);
//        $('input[type="checkbox"]:checked').prop('checked',false);
//    }
//       $('input[type="radio"]').click(function(){
//        var rsetis_call = $('input[name="UnwillingCallCenterForm[rsetis_call]"]:checked').val();
//        var express_call = $('input[name="UnwillingCallCenterForm[express_reluctance]"]:checked').val();
//        if(rsetis_call == '1')
//    {
//        $('#yes').css("display","block");
//    }
//    else
//    {   $('#yes').css("display","none");
//        $('input[name="UnwillingCallCenterForm[express_reluctance]"]').prop('checked', false);
//        $('input[type="checkbox"]:checked').prop('checked',false);
//    }
//         if(express_call == '1')
//    {
//        $('.form-group field-unwillingcallcenterform-unwilling_reason').css("display","block");
//        
//    }
//    else
//    {   $('.form-group field-unwillingcallcenterform-unwilling_reason').css("display","none");
//        
//    }
//    });
    
    });         
JS;
$this->registerJs($js);
?>
















