<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;

$this->title = 'अनिच्छा प्रकट करने के कारण';
$mobileopt = ['type' => 'number'];
?>
<?php echo $this->render('bc_view_unwilling', ['model' => $model]); ?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <!--            <div class="panel-hdr">
                            <h2>
            <?= 'अनिच्छा प्रकट करने के कारण' ?>
                            </h2>
            
                        </div>-->
            <div class="panel-container show">
                <div class="panel-content h3 font-weight-bold">


                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => false,
                                'enableAjaxValidation' => TRUE,
                                'options' => ['id' => 'unwilling', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>

                    <?=
                    $form->field($model, 'unwilling_reason', [
                        'labelOptions' => []
                    ])->checkboxList($model->unwilling_reason_option)
                    ?>
                    <div class="box border p-2">

                        <div class=" col-lg-12 font-weight-bold h3">क्या बीसी के सभी पेंडेंसी माइलस्टोन प्राप्त किए गए हैं? टिक करें</div>
                        <div class="row">
                            <div class="col-lg-4">   
                                <?= $form->field($model, 'is_pvr')->radioList($model->yes_no_option) ?>
                            </div> 
                            <div class="col-lg-4">
                                <?= $form->field($model, 'is_shg_assign')->radioList($model->yes_no_option) ?>
                            </div>
                            <div class="col-lg-4">   
                                <?= $form->field($model, 'is_bc_shg_bank')->radioList($model->yes_no_option) ?>
                            </div> 
                        </div> 

                        <div class="row">

                            <div class="col-lg-4">
                                <?= $form->field($model, 'is_pfms_mapping')->radioList($model->yes_no_option) ?>
                            </div>
                            <div class="col-lg-4">   
                                <?= $form->field($model, 'is_support_fund_shg')->radioList($model->yes_no_option) ?>
                            </div> 
                            <div class="col-lg-4">      
                                <?= $form->field($model, 'is_handheld_machine')->radioList($model->yes_no_option) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4"> 
                                <?= $form->field($model, 'is_onboarding')->radioList($model->yes_no_option) ?>
                            </div> 
                            <div class="col-lg-4">         
                                <?= $form->field($model, 'is_bc_operational')->radioList($model->yes_no_option) ?>
                            </div>
                        </div> 
                    </div>
                    <div class="box border p-2">
                        <div class="row">
                            <div class="col-lg-4"> 
                                <?= $form->field($model, 'is_bc_receive_support_fund')->radioList($model->yes_no_option) ?>
                            </div> 
                            <div class="col-lg-4">         
                                <?= $form->field($model, 'funds_returned_to_shg')->radioList($model->yes_no_option) ?>
                            </div>
                            <div class="col-lg-4"> 
                                <?php
                                echo $form->field($model, 'return_date_of_support_fund')->widget(DatePicker::classname(), [
                                    'value' => $model->return_date_of_support_fund,
                                    'options' => ['placeholder' => 'किस तारीख़ तक वापस करेंगे, संकेत करें ', 'class' => 'calculateday', 'readonly' => 'readonly'],
                                    'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                                    'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                                    'pluginOptions' => [
                                        'orientation' => 'bottom',
                                        'readonly' => 'readonly',
                                        'format' => 'yyyy-mm-dd',
                                        'todayHighlight' => true,
                                        'autoclose' => true,
                                        'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                                    ],
                                    'pluginEvents' => [
                                        "changeDate" => "function(e) { "
                                        . "}",
                                    ]
                                ]);
                                ?>
                            </div> 
                        </div>       
                        <div class="row">


                            <div class="col-lg-6">        
                                <?= $form->field($model, 'support_fund_responsible_name')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-lg-6"> 
                                <?= $form->field($model, 'support_fund_responsible_mobile_no')->textInput($mobileopt) ?>
                            </div>
                        </div> 

                    </div>
                    <div class="col-lg-12 pt-2">
                        <?=
                        $form->field($model, 'confirm', [
                            'template' => "<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                        ])->checkbox([
//                'checked' => false, 'required' => true,
                            'label' => "मैंने पार्टनर एजेंसी/ मुख्य विकास अधिकारी के प्रतिनिधित्व में वस्तुस्थिति की परीक्षण के बाद पूरी ज़िम्मेदारी से बीसी सखी के फण्ड वापसी कन्फर्म किया है। इस रिपोर्ट के सत्यता की ज़िम्मेदारी मुझ पर है ।"
                        ])->label();
                        ?>
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
        $(".field-unwillingcdonewform-funds_returned_to_shg").css("display","none");
        $(".field-unwillingcdonewform-return_date_of_support_fund").css("display","none");
        $(".field-unwillingcdonewform-support_fund_responsible_name").css("display","none");
        $(".field-unwillingcdonewform-support_fund_responsible_mobile_no").css("display","none");
        $(".field-unwillingcdonewform-confirm").css("display","none");
        $('#unwillingcdonewform-confirm').prop('checked', false);
         $('input[type=radio][name="UnwillingCdoNewForm[is_bc_receive_support_fund]').change(function() {      
        if($(this).val()=='1') {
           $(".field-unwillingcdonewform-funds_returned_to_shg").css("display","block");       
        } else {
            $(".field-unwillingcdonewform-confirm").css("display","none");
            $('#unwillingcdonewform-confirm').prop('checked', false)
            $(".field-unwillingcdonewform-funds_returned_to_shg").css("display","none"); 
            $('input[name="UnwillingCdoNewForm[funds_returned_to_shg]"]').prop('checked', false);
            $(".field-unwillingcdonewform-return_date_of_support_fund").css("display","none");
            $(".field-unwillingcdonewform-support_fund_responsible_name").css("display","none");
            $(".field-unwillingcdonewform-support_fund_responsible_mobile_no").css("display","none");
            $("#unwillingcdonewform-return_date_of_support_fund").val('');
            $("#unwillingcdonewform-support_fund_responsible_name").val('');
            $("#unwillingcdonewform-support_fund_responsible_mobile_no").val('');
        }
       });
       $('input[type=radio][name="UnwillingCdoNewForm[funds_returned_to_shg]').change(function() { 
           if($(this).val()=='1') {
            $(".field-unwillingcdonewform-confirm").css("display","block");
           } else {
            $(".field-unwillingcdonewform-confirm").css("display","none");
            $('#unwillingcdonewform-confirm').prop('checked', false)
          }
        if($(this).val()=='2') {
            $(".field-unwillingcdonewform-confirm").css("display","none");
            $(".field-unwillingcdonewform-return_date_of_support_fund").css("display","block");
            $(".field-unwillingcdonewform-support_fund_responsible_name").css("display","block");
            $(".field-unwillingcdonewform-support_fund_responsible_mobile_no").css("display","block");    
        } else {
            $(".field-unwillingcdonewform-return_date_of_support_fund").css("display","none");
            $(".field-unwillingcdonewform-support_fund_responsible_name").css("display","none");
            $(".field-unwillingcdonewform-support_fund_responsible_mobile_no").css("display","none");
            $("#unwillingcdonewform-return_date_of_support_fund").val('');
            $("#unwillingcdonewform-support_fund_responsible_name").val('');
            $("#unwillingcdonewform-support_fund_responsible_mobile_no").val('');
        }
       });      
    });         
JS;
$this->registerJs($js);
?>

<?php
$js = <<<JS
 $(function() {    
$('#unwilling').on('beforeSubmit', function (e) {
    var form = $(this);
    var submit = form.find(':submit');
    submit.html('<span class="fa fa-spin fa-spinner"></span> Wait...');
    submit.prop('disabled', true);

}); 
});    
JS;
$this->registerJs($js);
?>












