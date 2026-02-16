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
                    <?= 'Capturing unwilling of BCs : ' . $model->bc_model->name ?>
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

                    <?= $form->field($model, 'rsetis_call')->radioList($model->yes_no_option); ?>  
                    <div id="yes" style="display: none" >
                        <?= $form->field($model, 'express_reluctance')->radioList($model->yes_no_option); ?> 
                        <?= $form->field($model, 'unwilling_reason')->checkboxList($model->unwilling_reason_option) ?>
                        
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
  
        var rsetis_call = $('input[name="UnwillingBankCallCenterForm[rsetis_call]"]:checked').val();
        if(rsetis_call == '1')
    {
        $('#yes').css("display","block");
        
    }
    else
    {
        $('#yes').css("display","none");
        $('input[name="UnwillingBankCallCenterForm[express_reluctance]"]').prop('checked', false);
        $('input[type="checkbox"]:checked').prop('checked',false);
    }
       $('input[type="radio"]').click(function(){
        var rsetis_call = $('input[name="UnwillingBankCallCenterForm[rsetis_call]"]:checked').val();
        var express_call = $('input[name="UnwillingBankCallCenterForm[express_reluctance]"]:checked').val();
        if(rsetis_call == '1')
    {
        $('#yes').css("display","block");
    }
    else
    {   $('#yes').css("display","none");
        $('input[name="UnwillingBankCallCenterForm[express_reluctance]"]').prop('checked', false);
        $('input[type="checkbox"]:checked').prop('checked',false);
    }
         if(express_call == '1')
    {
        $('.form-group field-unwillingbankcallcenterform-unwilling_reason').css("display","block");
        $('.form-group field-unwillingbankcallcenterform-unwilling_reason7_text').css("display","block");
    }
    else
    {   $('.form-group field-unwillingbankcallcenterform-unwilling_reason').css("display","none");
        $('.form-group field-unwillingbankcallcenterform-unwilling_reason7_text').css("display","none");
    }
    });
    
    });         
JS;
$this->registerJs($js);
?>
















