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
//$js = <<<JS
//    $(document).ready(function() { 
//        $(".field-unwillingbanknewform-funds_returned_to_shg").css("display","none");
//        $(".field-unwillingbanknewform-return_date_of_support_fund").css("display","none");
//        $(".field-unwillingbanknewform-support_fund_responsible_name").css("display","none");
//        $(".field-unwillingbanknewform-support_fund_responsible_mobile_no").css("display","none");
//        $(".field-unwillingbanknewform-confirm").css("display","none");
//        $('#unwillingbanknewform-confirm').prop('checked', false);
//         $('input[type=radio][name="UnwillingBankNewForm[is_bc_receive_support_fund]').change(function() {      
//        if($(this).val()=='1') {
//           $(".field-unwillingbanknewform-funds_returned_to_shg").css("display","block");       
//        } else {
//            $(".field-unwillingbanknewform-confirm").css("display","none");
//            $('#unwillingbanknewform-confirm').prop('checked', false)
//            $(".field-unwillingbanknewform-funds_returned_to_shg").css("display","none"); 
//            $('input[name="UnwillingBankNewForm[funds_returned_to_shg]"]').prop('checked', false);
//            $(".field-unwillingbanknewform-return_date_of_support_fund").css("display","none");
//            $(".field-unwillingbanknewform-support_fund_responsible_name").css("display","none");
//            $(".field-unwillingbanknewform-support_fund_responsible_mobile_no").css("display","none");
//            $("#unwillingbanknewform-return_date_of_support_fund").val('');
//            $("#unwillingbanknewform-support_fund_responsible_name").val('');
//            $("#unwillingbanknewform-support_fund_responsible_mobile_no").val('');
//        }
//       });
//       $('input[type=radio][name="UnwillingBankNewForm[funds_returned_to_shg]').change(function() { 
//           if($(this).val()=='1') {
//            $(".field-unwillingbanknewform-confirm").css("display","block");
//           } else {
//            $(".field-unwillingbanknewform-confirm").css("display","none");
//            $('#unwillingbanknewform-confirm').prop('checked', false)
//          }
//        if($(this).val()=='2') {
//            $(".field-unwillingbanknewform-confirm").css("display","none");
//            $(".field-unwillingbanknewform-return_date_of_support_fund").css("display","block");
//            $(".field-unwillingbanknewform-support_fund_responsible_name").css("display","block");
//            $(".field-unwillingbanknewform-support_fund_responsible_mobile_no").css("display","block");    
//        } else {
//            $(".field-unwillingbanknewform-return_date_of_support_fund").css("display","none");
//            $(".field-unwillingbanknewform-support_fund_responsible_name").css("display","none");
//            $(".field-unwillingbanknewform-support_fund_responsible_mobile_no").css("display","none");
//            $("#unwillingbanknewform-return_date_of_support_fund").val('');
//            $("#unwillingbanknewform-support_fund_responsible_name").val('');
//            $("#unwillingbanknewform-support_fund_responsible_mobile_no").val('');
//        }
//       });      
//    });         
//JS;
//$this->registerJs($js);
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












