<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$scenario_form = '';
?>
<script>

    var date = <?= isset($model->month1_acknowledge_recived_date) ? strtotime($model->month1_acknowledge_recived_date) . '000' : 0 ?>;
    var mindate = <?= strtotime('2021-06-01') . '000' ?>;
    var maxdate = <?= time() . '000' ?>;
</script>
<div class='card'>
    <div class="col-lg-12">  
        <?= $form->field($model, 'month1_acknowledge_rishta_notification')->label('मानदेय मिलने की पूर्व सूचना रिश्ता मोबाइल ऐप पर समय से मिली?')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?>
    </div>
</div>
<div class='card'>
    <div class="col-lg-12">    
        <?= $form->field($model, 'month1_acknowledge')->label('मानदेय मिल गया है')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?>  
    </div>
</div>
<div class="month_acknowledge1">
    <div class="card">
        <div class="col-lg-12"> 
            <?php echo $form->field($model, "month1_acknowledge_amount")->label('मानदेय राशि मिला')->textInput(['type' => 'number']) ?>
        </div>
    </div>

    <div class='card'>
        <div class="col-lg-12">   
             <?php
            echo $form->field($model, "month1_acknowledge_recived_date")->widget(DatePicker::classname(), [
                'value' => $model->month1_acknowledge_recived_date,
                'options' => ['placeholder' => 'मानदेय प्राप्त दिनांक', 'class' => 'calculateday', 'readonly' => 'readonly'],
                'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                'pluginOptions' => [
                    'readonly' => 'readonly',
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'autoclose' => true,
                    'minDate' => '2021-01-01',
                    'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                ],
            ])->label('मानदेय प्राप्त दिनांक');
            ?>
            <?php
//            $form->field($model, 'month1_acknowledge_recived_date', [
//                'inputTemplate' => '<div class="input-group"><div class="input-group-prepend">
//        <span class="input-group-text"><i class="fal fa-calendar-alt text-primary"></i> </span>
//    </div>{input}</div>',
//            ])->textInput(['placeholder' => 'मानदेय प्राप्त दिनांक', 'readonly' => 'readonly', 'onclick' => "javascript:return showCalender(date,mindate,maxdate,'bcpaymenackform-month1_acknowledge_recived_date');"])->label('मानदेय प्राप्त दिनांक')
            ?>  
        </div>
    </div>
</div> 
<div class="month_acknowledge2">
    <div class='card'>
        <div class="col-lg-12">
            <?= $form->field($model, 'month1_acknowledge_not_recived_reason')->label('अगर नहीं, तो क्या आपके बैंक अकाउंट में असुविधा के कारण भुगतान वाधित है?')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?>  
        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">
            <?= $form->field($model, 'month1_acknowledge_not_recived_reason_other')->label('भुगतान ना होने के अन्य कारण हैं ')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?>  
        </div>
    </div>

</div>    
<?php
$js = <<<JS
    $(document).ready(function() {
        $(".month_acknowledge1").css("display","none");
        $(".month_acknowledge2").css("display","none");
         if($('input[type=radio][name="BCPaymenAckForm[month1_acknowledge]"]:checked').val()=='1'){
             $(".month_acknowledge1").css("display","block")
        }  

         if($('input[type=radio][name="BCPaymenAckForm[month1_acknowledge]"]:checked').val()=='2'){
            $(".month_acknowledge2").css("display","block")
        }

        $('input[type=radio][name="BCPaymenAckForm[month1_acknowledge]"]').change(function() {
            if($(this).val() =='1'){
                $(".month_acknowledge1").css("display","block") 
                $(".month_acknowledge2").css("display","none");
            } else if($(this).val() =='2'){ 
                $(".month_acknowledge1").css("display","none");
                $(".month_acknowledge2").css("display","block");
            } else {
            $(".month_acknowledge1").css("display","none");
            $(".month_acknowledge2").css("display","none");
           }
        })

        // Rest Element Values of This Form
        $('form').change(function(e)
        {
            
            
        });

       
    });
JS;
$this->registerJs($js);
?>