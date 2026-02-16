<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
use common\models\wada\master\WadaApplicationMasterSchemesGain1;
use common\models\wada\master\WadaApplicationMasterSchemesGain2;
use common\models\wada\master\WadaApplicationMasterSchemesGain3;
use common\models\wada\master\WadaApplicationMasterSchemesGain4;
use common\models\wada\master\WadaApplicationMasterSchemesGain5;

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
        Section 5 : मल्टी-सेक्टर सेवाओं के बारे में जानकारी
    </h3>
</div>
<br />
<div class="card">

    <div class="col-lg-12">

        <div class='card-body'>
            <?php $form = ActiveMobileForm::begin(['id' => 'form-shg-application_form', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>

            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "applicant_know_different_schemes_their_provisions")->dropDownList(["1" => "नहीं", "2" => "हाँ, बहुत अच्छी तरह से", "3" => "हाँ, पर कोई खाँस नहीं", "4" => "ग़रीबों के लिए बहुत प्रावधान है", "5" => "गरीब और महिलाओं के लिए प्रावधान है"], ['prompt' => 'चयन कीजिए']) ?>
                </div>
            </div>

            <div class='card'>
                <label style="padding-left:10px" for="applicationform-existing_member_role">2. क्या आवेदक निम्न योजनाओं के बारे में जानती हैं?</label>
                <div class='card'>
                    <div class="col-lg-12">
                        <?php echo $form->field($model, "applicants_know_about_following_schemes1")->dropDownList(["1" => "हाँ", "2" => "नहीं"], ['prompt' => 'चयन कीजिए']) ?>
                    </div>

                    <div class="col-lg-12">
                        <?php echo $form->field($model, "applicants_know_about_following_schemes1_the_gain")->dropDownList(ArrayHelper::map(WadaApplicationMasterSchemesGain1::find()->where(['status' => 1])->all(), 'id', 'name_hi'), ['prompt' => 'चयन कीजिए']) ?>
                    </div>
                </div>

                <hr />

                <div class='card'>
                    <div class="col-lg-12">
                        <?php echo $form->field($model, "applicants_know_about_following_schemes2")->dropDownList(["1" => "हाँ", "2" => "नहीं"], ['prompt' => 'चयन कीजिए']) ?>
                    </div>

                    <div class="col-lg-12">
                        <?php echo $form->field($model, "applicants_know_about_following_schemes2_the_gain")->dropDownList(ArrayHelper::map(WadaApplicationMasterSchemesGain2::find()->where(['status' => 1])->all(), 'id', 'name_hi'), ['prompt' => 'चयन कीजिए']) ?>
                    </div>
                </div>

                <hr />

                <div class='card'>
                    <div class="col-lg-12">
                        <?php echo $form->field($model, "applicants_know_about_following_schemes3")->dropDownList(["1" => "हाँ", "2" => "नहीं"], ['prompt' => 'चयन कीजिए']) ?>
                    </div>

                    <div class="col-lg-12">
                        <?php echo $form->field($model, "applicants_know_about_following_schemes3_the_gain")->dropDownList(ArrayHelper::map(WadaApplicationMasterSchemesGain3::find()->where(['status' => 1])->all(), 'id', 'name_hi'), ['prompt' => 'चयन कीजिए']) ?>
                    </div>
                </div>

                <hr />

                <div class='card'>
                    <div class="col-lg-12">
                        <?php echo $form->field($model, "applicants_know_about_following_schemes4")->dropDownList(["1" => "हाँ", "2" => "नहीं"], ['prompt' => 'चयन कीजिए']) ?>
                    </div>

                    <div class="col-lg-12">
                        <?php echo $form->field($model, "applicants_know_about_following_schemes4_the_gain")->dropDownList(ArrayHelper::map(WadaApplicationMasterSchemesGain4::find()->where(['status' => 1])->all(), 'id', 'name_hi'), ['prompt' => 'चयन कीजिए']) ?>
                    </div>
                </div>

                <hr />

                <div class='card'>
                    <div class="col-lg-12">
                        <?php echo $form->field($model, "applicants_know_about_following_schemes5")->dropDownList(["1" => "हाँ", "2" => "नहीं"], ['prompt' => 'चयन कीजिए']) ?>
                    </div>

                    <div class="col-lg-12">
                        <?php echo $form->field($model, "applicants_know_about_following_schemes5_the_gain")->dropDownList(ArrayHelper::map(WadaApplicationMasterSchemesGain5::find()->where(['status' => 1])->all(), 'id', 'name_hi'), ['prompt' => 'चयन कीजिए']) ?>
                    </div>
                </div>




            </div>




            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "applicant_himself_beneficiary_these_schemes")->dropDownList(yii\helpers\ArrayHelper::map(common\models\wada\master\WadaApplicationMasterYourselfBeneficiariesOfSchemes::find()->where(['status' => 1])->all(), 'id', 'name_hi'), ['prompt' => 'चयन कीजिए']) ?>
                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "whethe_members_beneficiaries_of_these_schemes")->dropDownList(yii\helpers\ArrayHelper::map(common\models\wada\master\WadaApplicationMasterBeneficiariesOfSchemes::find()->where(['status' => 1])->all(), 'id', 'name_hi'), ['prompt' => 'चयन कीजिए']) ?>
                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "eligibility_level_of_such_schemes")->dropDownList(["1" => "सभी सदस्य सभी योजना के पात्र हैं ", "2" => "ज़्यादातर सदस्य कुछ योजना के पात्र हैं", "3" => "कोई भी सदस्य किसी भी योजना के पात्र नहीं हैं", "4" => "किसी सदस्य के पात्रता के बारे में कोई समझ/ जानकारी नहीं है"], ['prompt' => 'चयन कीजिए']) ?>
                </div>
            </div>

            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "think_about_need_wada_sakhi")->dropDownList(["1" => "बहुत ही ज़्यादा ज़रूरत है", "2" => "आवश्यक है, पर इनके बिना भी काम चल रहा है", "3" => "कोई ज़रूरत नहीं है"], ['prompt' => 'चयन कीजिए']) ?>
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
        $(".field-applicationform-applicants_know_about_following_schemes1_the_gain").css("display","none");
        $(".field-applicationform-applicants_know_about_following_schemes2_the_gain").css("display","none");
        $(".field-applicationform-applicants_know_about_following_schemes3_the_gain").css("display","none");
        $(".field-applicationform-applicants_know_about_following_schemes4_the_gain").css("display","none");
        $(".field-applicationform-applicants_know_about_following_schemes5_the_gain").css("display","none");
    $("#applicationform-applicants_know_about_following_schemes1").on("change", function() {
        if ($(this).val() === "1") {
             $(".field-applicationform-applicants_know_about_following_schemes1_the_gain").css("display","block");           
        } else{
            $("#applicationform-applicants_know_about_following_schemes1_the_gain")[0].selectedIndex = 0;
            $(".field-applicationform-applicants_know_about_following_schemes1_the_gain").css("display","none");
            
      }
  });
  $("#applicationform-applicants_know_about_following_schemes2").on("change", function() {
        if ($(this).val() === "1") {
             $(".field-applicationform-applicants_know_about_following_schemes2_the_gain").css("display","block");           
        } else{
            $("#applicationform-applicants_know_about_following_schemes2_the_gain")[0].selectedIndex = 0;
            $(".field-applicationform-applicants_know_about_following_schemes2_the_gain").css("display","none");
            
      }
  });     
   $("#applicationform-applicants_know_about_following_schemes3").on("change", function() {
        if ($(this).val() === "1") {
             $(".field-applicationform-applicants_know_about_following_schemes3_the_gain").css("display","block");           
        } else{
            $("#applicationform-applicants_know_about_following_schemes3_the_gain")[0].selectedIndex = 0;
            $(".field-applicationform-applicants_know_about_following_schemes3_the_gain").css("display","none");
            
      }
  });
  $("#applicationform-applicants_know_about_following_schemes4").on("change", function() {
        if ($(this).val() === "1") {
             $(".field-applicationform-applicants_know_about_following_schemes4_the_gain").css("display","block");           
        } else{
            $("#applicationform-applicants_know_about_following_schemes4_the_gain")[0].selectedIndex = 0;
            $(".field-applicationform-applicants_know_about_following_schemes4_the_gain").css("display","none");
            
      }
  });
  $("#applicationform-applicants_know_about_following_schemes5").on("change", function() {
        if ($(this).val() === "1") {
             $(".field-applicationform-applicants_know_about_following_schemes5_the_gain").css("display","block");           
        } else{
            $("#applicationform-applicants_know_about_following_schemes5_the_gain")[0].selectedIndex = 0;
            $(".field-applicationform-applicants_know_about_following_schemes5_the_gain").css("display","none");
            
      }
  });     
    });         
JS;
$this->registerJs($js);
?>