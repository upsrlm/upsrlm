<?php

use yii\helpers\Html;
use sakhi\widgets\ActiveMobileForm;
use kartik\date\DatePicker;

$namopt = ['maxlength' => true];
$mobileopt = ['type' => 'number'];
if (isset($model->shg_member_model->id)) {
    $namopt = ['maxlength' => true, 'readonly' => 'readonly'];
    $mobileopt = ['readonly' => 'readonly'];
}
?>
<script type="text/javascript">
    var date = <?= isset($model->loan_date) ? strtotime($model->loan_date) . '000' : 0 ?>;
    var mindate = <?= strtotime('2000-01-01') . '000' ?>;
    var maxdate = <?= time() . '000' ?>;

</script>
<?php $form = ActiveMobileForm::begin(['id' => 'form-shgmember', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
<div class="row">

    <div class="col-lg-6">
        <?php echo $form->field($model, "name")->label('समूह द्वारा मनोनीत आवेदक का नाम')->textInput($namopt) ?>

    </div>  
    <div class="col-lg-6">
        <?php echo $form->field($model, "mobile")->label('मोबाइल न0')->textInput($mobileopt) ?>

    </div>  

    <div class="col-lg-6">
        <?php echo $form->field($model, "marital_status")->dropDownList([0 => 'नहीं', '1' => 'हाँ'], ['prompt' => 'चयन कीजिए']) ?>
    </div>

    <div class="col-lg-6">
        <?php echo $form->field($model, "age")->dropDownList([1 => '18-25', 2 => '26-35', 3 => '36-50', 4 => '50+'], ['prompt' => 'चयन कीजिए']) ?>
    </div>

    <div class="col-lg-6">
        <?php echo $form->field($model, "caste_category")->dropDownList([1 => 'अनुसूचित जाति/जनजाति', 2 => 'अन्य पिछड़ा वर्ग', 3 => 'सामान्य'], ['prompt' => 'चयन कीजिए']) ?>
    </div>

    <div class="col-lg-6">
        <?php echo $form->field($model, "duration_of_membership")->dropDownList([1 => '12 महीने से कम', 2 => '13 से 30 महीने', 3 => '31-60 महीने'], ['prompt' => 'चयन कीजिए']) ?>
    </div>

    <div class="col-lg-6">
        <?php echo $form->field($model, "total_saving")->dropDownList([1 => '>5000', 2 => '5,000-20,000', 3 => '<20,000'], ['prompt' => 'चयन कीजिए']) ?>
    </div>

    <div class="col-lg-6">
        <?php echo $form->field($model, "loan")->dropDownList([0 => 'नहीं', '1' => 'हाँ'], ['prompt' => 'चयन कीजिए']) ?>
    </div>

    <div class="col-lg-6" id="loan_count" style="display: <?php
    if ($model->loan == 1) {
        echo 'block';
    } else {
        echo 'none';
    }
    ?>;">
         <?php echo $form->field($model, "loan_count")->label('अगर हाँ, तो कितनी बार ')->textInput(['type' => 'number', 'min' => 0]) ?>
    </div>

    <div class="col-lg-6" id="loan_amount" style="display: <?php
    if ($model->loan == 1) {
        echo 'block';
    } else {
        echo 'none';
    }
    ?>;">
         <?php echo $form->field($model, "loan_amount")->label('ऋण के रकम')->textInput(['type' => 'number', 'min' => 0]) ?>
    </div>

    <div class="col-lg-6" id="loan_date" style="display: <?php
    if ($model->loan == 1) {
        echo 'block';
    } else {
        echo 'none';
    }
    ?>;">
         <?=
         $form->field($model, 'loan_date', [
             'inputTemplate' => '<div class="input-group"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fal fa-calendar-alt text-primary"></i> </span>
    </div>{input}</div>',
         ])->textInput(['placeholder' => 'ऋण के तिथि', 'readonly' => 'readonly', 'onclick' => "javascript:return showCalender(date,mindate,maxdate,'rishtashgmemberform-loan_date');"])->label('ऋण के तिथि')
         ?>     
         <?php
//        $form->field($model, 'loan_date')->widget(DatePicker::classname(), [
//            'options' => ['placeholder' => 'ऋण के तिथि'],
//            'pluginOptions' => [
//                'autoclose' => true,
//                'format' => 'yyyy-mm-dd'
//            ],
//            'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
//            'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
//        ])
         ?>  
    </div>

    <div class="col-lg-6" id="mcp_status" style="display: <?php
    if ($model->loan == 0) {
        echo 'block';
    } else {
        echo 'none';
    }
    ?>;">
         <?php echo $form->field($model, "mcp_status")->dropDownList([1 => 'बना है', 2 => 'नहीं बना है', 3 => 'पता नहीं'], ['prompt' => 'चयन कीजिए']) ?>
    </div>

</div>


<div class="form-group text-center">

    <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'shg_member_id')->hiddenInput()->label(false); ?>

    <?= Html::submitButton('सेव', ['class' => 'btn btn-sm btn-info form-control mt-2', 'name' => 'save_b', 'id' => 'save_b']) ?>
</div>
<?php ActiveMobileForm::end(); ?>


<?php
$script = <<< JS
    $(function(){
        $('#rishtashgmemberform-loan').change(function(){
                var selectded_value = this.value;

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
        function loan_check(){
        
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
        }
        loan_check();
    });
JS;
$this->registerJs($script);
?>