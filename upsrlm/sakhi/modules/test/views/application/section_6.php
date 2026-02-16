<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
use common\models\wada\master\WadaApplicationMasterCast;
use common\models\wada\master\WadaApplicationMasterEducationalLevel;
use common\models\wada\master\WadaApplicationMasterMarriageStatus;
use common\models\wada\master\WadaApplicationMasterVocationalTraining;

$this->title = 'आवेदन पत्र';
$app = new \sakhi\components\App();
?>
<script type="text/javascript">
    var date = <?= isset($model->dob) ? strtotime($model->dob) . '000' : 0 ?>;
    var mindate = <?= strtotime('1960-01-01') . '000' ?>;
    var maxdate = <?= strtotime('2004-01-01') . '000' ?>;
</script>
<div class="subheader" style="text-align: center">
    <h3 class="subheader-title">
        Section 6
    </h3>
</div>
<br />
<div class="card">

    <div class="col-lg-12">

        <div class='card-body'>
            <?php $form = ActiveMobileForm::begin(['id' => 'form-shg-application_form', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>


            <div class='card'>
                <div class="col-lg-12">
                    <?php
                    echo Html::activeLabel($model, "mobile_feature")
                    ?>
                    <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>

                        <?php echo $form->field($model, "mobile_feature1", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "mobile_feature2", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "mobile_feature3", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "mobile_feature4", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "mobile_feature5", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "mobile_feature6", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "mobile_feature7", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "mobile_feature8", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                    </div>
                </div>

                <div class="col-lg-12 mt-2">
                    <?php echo $form->field($model, "mobile_feature_benefit")->dropDownList([1 => 'हाँ, बहुत ही ज़्यादा - आर्थिक लाभ होगा', '2' => 'ठीक है, पर इनके बिना भी काम चल रहा है', '3' => 'इसकी कोई ज़रूरत नहीं है'], ['prompt' => 'चयन कीजिए']) ?>
                </div>

                <div class="col-lg-12 mt-2" id="wanttopay">
                    <?php echo $form->field($model, "pay")->dropDownList([0 => 'नहीं', '1' => 'हाँ'], ['prompt' => 'चयन कीजिए']) ?>
                </div>

                <div class="col-lg-12 mt-2" id="paymentyes">
                    <?php echo $form->field($model, "pay_type")->dropDownList(['1' => 'पंजीकरण शुल्क (सिर्फ़ एकबार)', '2' => 'यूज़र शुल्क (प्रति माह)', '3' => 'कोई अन्य शुल्क (प्रति माह)'], ['prompt' => 'चयन कीजिए']) ?>

                    <div class="col-lg-12" id="paymentyes1">
                        <?php echo $form->field($model, "pay_amount1")->radioList([20 => '20', 50 => '50', 100 => '100']) ?>
                    </div>

                    <div class="col-lg-12" id="paymentyes2">
                        <?php echo $form->field($model, "pay_amount2")->radioList([5 => '5', 10 => '10', 25 => '25']) ?>
                    </div>

                    <div class="col-lg-12" id="paymentyes3">
                        <?php echo $form->field($model, "pay_amount3")->radioList([5 => '5', 10 => '10', 25 => '25']) ?>
                    </div>
                </div>

                <div class="col-lg-12 mt-2">
                    <?php echo $form->field($model, "any_proble_filling_form")->radioList(yii\helpers\ArrayHelper::map(common\models\wada\master\WadaApplicationMasterFormTrouble::find()->where(['status' => 1])->all(), 'id', 'name_hi')) ?>
                </div>

            </div>

            <div class="form-group text-center">
                <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label('') ?>
                <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/application/form', ['shgid' => $model->cbo_shg_id])) { ?>
                    <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                    <?php Html::submitButton('सबमिट (Submit)', ['class' => 'btn btn-small btn-info', 'name' => 'submit_b', 'id' => 'submit_b']) ?>
                <?php } ?>
            </div>
            <?php ActiveMobileForm::end(); ?>

        </div>
    </div>
</div>


<style>
    .col-lg-12 {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }

    .card .card-body {
        padding: 0px
    }

    .card-body .card {
        margin: 5px 0px
    }

    .card-body .card> :last-child,
    .card-group> :last-child {
        margin-bottom: 10px;
        margin-top: 5px;
    }

    .form-group:last-child,
    .form-group:only-child {
        margin-bottom: 10px;
    }
</style>

<?php
$js = <<<JS
    $(document).ready(function() {
        $("#wanttopay").css("display","none");
        $("#paymentyes").css("display","none");
        $("#paymentyes1").css("display","none");
        $("#paymentyes2").css("display","none");
        $("#paymentyes3").css("display","none");

        $("#applicationform-mobile_feature_benefit").on("change", function() {
            if ($(this).val() === "1") {
                $("#wanttopay").css("display","block");
            } else{
                $("#wanttopay").css("display","none");
                $("#paymentyes").css("display","none");
                $("#applicationform-pay")[0].selectedIndex = 0;
                $("#applicationform-pay_type")[0].selectedIndex = 0;
            }
        }); 


        $("#applicationform-pay").on("change", function() {
            if ($(this).val() === "1") {
                $("#paymentyes").css("display","block");
            } else{
                $("#paymentyes").css("display","none");
                $("#paymentyes1").css("display","none");
                $("#paymentyes2").css("display","none");
                $("#paymentyes3").css("display","none");
                $("#applicationform-pay_type")[0].selectedIndex = 0;
            }
        }); 

        $("#applicationform-pay_type").on("change", function() {
            $("#paymentyes1").css("display","none");
            $("#paymentyes2").css("display","none");
            $("#paymentyes3").css("display","none");
            if ($(this).val() === "1") {
                $("#paymentyes1").css("display","block");
            }else if ($(this).val() === "2") {
                $("#paymentyes2").css("display","block");
            }else if ($(this).val() === "3") {
                $("#paymentyes3").css("display","block");
            }
        }); 
    
    });         
JS;
$this->registerJs($js);
?>