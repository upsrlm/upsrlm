<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use sakhi\widgets\ActiveMobileForm;
use kartik\widgets\DatePicker;

$this->title = 'अनिच्छुक बीसी सखी';
$mobileopt = ['type' => 'number'];
?>
<?php echo $this->render('bc_view_unwilling', ['model' => $model]); ?>
<?php if ($model->bc_model->bc_unwilling_bank == '1') { ?>     
    <?php if (!$model->bc_model->bc_unwilling_bc) { ?>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">

                    <div class="panel-container show">
                        <div class="panel-content h3 font-weight-bold">


                            <?php
                            $form = ActiveMobileForm::begin([
                                        'enableClientValidation' => false,
                                        'enableAjaxValidation' => TRUE,
                                        'options' => ['id' => 'unwilling', 'enctype' => 'multipart/form-data'],
                            ]);
                            ?>
                            <div class='card'>
                                <div class="col-lg-12">    
                                    <?= $form->field($model, 'bc_unwilling')->radioList($model->yes_no_option, ['separator' => '']); ?>  
                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12"> 
                                    <?=
                                    $form->field($model, 'unwilling_reason', [
                                        'labelOptions' => []
                                    ])->checkboxList($model->unwilling_reason_option)
                                    ?>
                                </div>
                            </div>         

                            <div class="form-group">
                                <div style="display: none">


                                    <?= $form->field($model, 'training_status')->hiddenInput()->label(false); ?>
                                    <?= $form->field($model, 'bc_application_id')->hiddenInput()->label(false); ?>
                                    <?= $form->field($model, 'bc_selection_user_id')->hiddenInput()->label(false); ?>
                                </div>
                                <div class="col-lg-offset-5 col-lg-11">
                                    <?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                                </div>
                            </div>
                            <?php ActiveMobileForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($model->bc_unwilling == 1) { ?>
            <script>
                $(".field-unwillingbcnewform-bc_unwilling").css("display", "none");
                $(".field-unwillingbcnewform-unwilling_reason").css("display", "block");
            </script>
        <?php } ?>
        <?php
        $js = <<<JS
    $(document).ready(function() { 
        $(".field-unwillingbcnewform-unwilling_reason").css("display","none");
        if($('input[type=radio][name="UnwillingBCNewForm[bc_unwilling]"]:checked').val()=='1'){
           $(".field-unwillingbcnewform-unwilling_reason").css("display","block");   
         }  
        $('input[type=radio][name="UnwillingBCNewForm[bc_unwilling]').change(function() {     
        if($(this).val()=='1') {
           $(".field-unwillingbcnewform-unwilling_reason").css("display","block");      
        } else {
            $(".field-unwillingbcnewform-unwilling_reason").css("display","none"); 
       
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

    <?php } ?>
<?php } ?>









