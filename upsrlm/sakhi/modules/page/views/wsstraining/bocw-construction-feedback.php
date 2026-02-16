<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = 'निर्माण कामगार मृत्यु व दिव्यांगता सहायता योजन पर प्रतिक्रिया';
$app = new \sakhi\components\App();
$option = ['separator' => '<br/>'];
if (isset($model->feedback_model->id)) {
    $option = ['separator' => '<br/>','disabled' => true];
}
?>
<div class="card">
    <div class="col-lg-12">
        <div class="text-center"> <b>उत्तर प्रदेश राज्य ग्रामीण आजीविका मिशन,</b> <br/>
            ग्राम्य विकास विभाग, उत्तर प्रदेश शासन <br/>
            <?=$this->title?>
        </div>
    </div>
    <div class="col-lg-12">

        <div class='card-body'>
            <?php $form = ActiveMobileForm::begin(['id' => 'form-shg-feedback', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
            <div class='card'>
                <div class="col-lg-12">    
                    <?= $form->field($model, 'ques1')->radioList($model->ques1_option, $option); ?>  
                </div>
            </div>
             <div class='card'>
                <div class="col-lg-12">    
                    <?= $form->field($model, 'ques2')->radioList($model->ques2_option, $option); ?>  
                </div>
            </div>
             <div class='card'>
                <div class="col-lg-12">    
                    <?= $form->field($model, 'ques3')->radioList($model->ques3_option, $option); ?>  
                </div>
            </div>
             <div class='card'>
                <div class="col-lg-12">    
                    <?= $form->field($model, 'ques4')->radioList($model->ques4_option, $option); ?>  
                </div>
            </div>
             <div class='card'>
                <div class="col-lg-12">    
                    <?= $form->field($model, 'ques5')->radioList($model->ques5_option, $option); ?>  
                </div>
            </div>
             <div class='card'>
                <div class="col-lg-12">    
                    <?= $form->field($model, 'ques6')->radioList($model->ques6_option, $option); ?>  
                </div>
            </div>
             <div class='card'>
                <div class="col-lg-12">    
                    <?= $form->field($model, 'ques7')->radioList($model->ques7_option, $option); ?>  
                </div>
            </div>
            <div class="form-group text-center">
                <?= $form->field($model, 'user_id')->hiddenInput()->label('') ?> 
               <?php if(!isset($model->feedback_model->id)){ ?>
                <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
               <?php } ?>
            </div>
            <?php ActiveMobileForm::end(); ?>
        </div>
    </div>    
</div>   
<?php
$js = <<<JS
    $(document).ready(function() {
        $(".field-dbtschemebocwconstructionfeedbackform-ques5").css("display","none");
  
         if($('input[type=radio][name="DbtSchemeBocwConstructionFeedbackForm[ques4]"]:checked').val()=='1'){
              $(".field-dbtschemebocwconstructionfeedbackform-ques5").css("display","none");
        }  

         if($('input[type=radio][name="DbtSchemeBocwConstructionFeedbackForm[ques4]"]:checked').val()=='2'){
            $(".field-dbtschemebocwconstructionfeedbackform-ques5").css("display","block");
        }

        $('input[type=radio][name="DbtSchemeBocwConstructionFeedbackForm[ques4]"]').change(function() {
            if($(this).val() =='1'){
                $(".field-dbtschemebocwconstructionfeedbackform-ques5").css("display","none");
            }else{ 
               $(".field-dbtschemebocwconstructionfeedbackform-ques5").css("display","block");
            }
        })
    });
JS;
$this->registerJs($js);
?>