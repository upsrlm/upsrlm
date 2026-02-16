<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\date\DatePicker;
?>

<?php $form = ActiveForm::begin(['id' => 'form-shgmember', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
<div class="row">

    <div class="col-lg-6">
        <?php echo $form->field($model, "name")->label('सदस्यों के नाम ')->textInput() ?>

    </div>  
    <div class="col-lg-6">
        <?php echo $form->field($model, "mobile")->label('मोबाइल न0')->textInput() ?>

    </div>  
    
    <div class="col-lg-6">
        <?php echo $form->field($model, "marital_status")->dropDownList([0 => 'नहीं', '1' => 'हाँ'],['prompt' => 'चयन कीजिए'])->label('वैवाहिक स्थिति') ?>
    </div>

    <div class="col-lg-6">
        <?php echo $form->field($model, "age")->dropDownList([1 => '18-25', 2 => '26-35',3=>'36-50',3=>'50+'] ,['prompt' => 'चयन कीजिए'])->label('आयु') ?>
    </div>

    <div class="col-lg-6">
        <?php echo $form->field($model, "caste_category")->dropDownList([1 => 'अनुसूचित जाति/जनजाति', 2 => 'अन्य पिछड़ा वर्ग',3=>'सामान्य'],['prompt' =>'चयन कीजिए'])->label('सामाजिक वर्ग') ?>
    </div>

    <div class="col-lg-6">
        <?php echo $form->field($model, "duration_of_membership")->dropDownList([1 => '12 महीने से कम', 2 => '13 से 30 महीने', 3=>'31-60 महीने'],['prompt' => 'चयन कीजिए'])->label('कितने समय से समूह के सदस्य हैं') ?>
    </div>

    <div class="col-lg-6">
        <?php echo $form->field($model, "total_saving")->dropDownList([1 => '>5000', 2 => '5,000-20,000',3=>'<20,000'],['prompt' => 'चयन कीजिए'])->label('अबतक समूह में कुल बचत') ?>
    </div>

    <div class="col-lg-6">
        <?php echo $form->field($model, "loan")->dropDownList([0 => 'नहीं', '1' => 'हाँ'],['prompt' =>'चयन कीजिए'])->label('ऋण') ?>
    </div>

    <div class="col-lg-6" id="loan_count" style="display: <?php if($model->loan==1){echo 'block';}else{echo 'none';} ?>;">
        <?php echo $form->field($model, "loan_count")->label('अगर हाँ, तो कितनी बार ')->textInput() ?>
    </div>

    <div class="col-lg-6" id="loan_amount" style="display: <?php if($model->loan==1){echo 'block';}else{echo 'none';} ?>;">
    <?php echo $form->field($model, "loan_amount")->label('ऋण के रकम')->textInput() ?>
    </div>

    <div class="col-lg-6" id="loan_date" style="display: <?php if($model->loan==1){echo 'block';}else{echo 'none';} ?>;">
        <?= $form->field($model, 'loan_date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'ऋण के तिथि'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ],
        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
    ]) ?>  
    </div>

    <div class="col-lg-6" id="mcp_status" style="display: <?php if($model->loan==0){echo 'block';}else{echo 'none';} ?>;">
        <?php echo $form->field($model, "mcp_status")->dropDownList([1 => 'बना है', 2 => 'नहीं बना है',3=>'पता नहीं'],['prompt' => 'चयन कीजिए'])->label('अगर ना, तो MCP की स्थिति') ?>
    </div>

</div>


<div class="form-group text-center">
    <?= Html::submitButton('सेव', ['class' => 'btn btn-lg btn-info mt-2', 'name' => 'save_b', 'id' => 'save_b']) ?>
</div>
<?php ActiveForm::end(); ?>


<?php
$script = <<< JS
    $(function(){
        function loan_check(){
            $('#shgmemberform-loan').change(function(){
                var selectded_value = document.getElementById("shgmemberform-loan").value;

                if(selectded_value ==1){
                    document.getElementById("loan_count").style.display = "block";
                    document.getElementById("loan_amount").style.display = "block";
                    document.getElementById("loan_date").style.display = "block";
                    document.getElementById("mcp_status").style.display = "none";
                }else{
                    document.getElementById("loan_count").style.display = "none";
                    document.getElementById("loan_amount").style.display = "none";
                    document.getElementById("loan_date").style.display = "none";
                    document.getElementById("mcp_status").style.display = "block";
                }
            });
        }
        loan_check();
    });
JS;
$this->registerJs($script);
?>