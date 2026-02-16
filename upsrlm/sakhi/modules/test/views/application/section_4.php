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
        Section 4 : नेतृत्व
    </h3>
</div>
<br />
<div class="card">

    <div class="col-lg-12">

        <div class='card-body'>
            <?php $form = ActiveMobileForm::begin(['id' => 'form-shg-application_form', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>

            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "shg_name")->label('1. आपके स्वयं सहायता समूह का नाम')->textInput(['readonly' => true]) ?>
                </div>

                <div class="col-lg-12">
                    <?php echo $form->field($model, "existing_member")->dropDownList(["1" => "हाँ", "2" => "नहीं"], ['prompt' => 'चयन कीजिए']) ?>
                </div>

                <div class="col-lg-12 officer">
                    <?php
                    echo Html::activeLabel($model, "existing_member_role")
                    //echo Html::error($model,'existing_member_role', ['class' => 'help-block']);  
                    ?>
                    <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>

                        <?php echo $form->field($model, "officer1", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "officer2", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "officer3", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "officer4", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "officer5", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "officer6", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "officer7", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "officer8", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "officer9", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "officer10", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "officer11", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "officer12", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                    </div>

                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "applicant_member_other_organization")->dropDownList(["1" => "हाँ", "2" => "नहीं"], ['prompt' => 'चयन कीजिए']) ?>
                </div>

                <div class="col-lg-12 applicant_member_other_organization">
                    <?php
                    echo Html::activeLabel($model, "applicant_member_other_organization_role")
                    //echo Html::error($model,'existing_member_role', ['class' => 'help-block']);  
                    ?>
                    <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                        <?php echo $form->field($model, "applicant_member_other_organization1", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "applicant_member_other_organization2", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "applicant_member_other_organization3", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "applicant_member_other_organization4", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "applicant_member_other_organization5", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "applicant_member_other_organization6", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>

                    </div>

                </div>
            </div>


            <div class='card election_in_future'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "election_in_future")->dropDownList(["1" => "हाँ", "2" => "नहीं"], ['prompt' => 'चयन कीजिए']) ?>
                </div>

                <div class="col-lg-12 election_in_future_role">
                    <?php
                    echo Html::activeLabel($model, "election_in_future_role")
                    //echo Html::error($model,'existing_member_role', ['class' => 'help-block']);  
                    ?>
                    <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                        <?php echo $form->field($model, "election_in_future1", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "election_in_future2", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "election_in_future3", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "election_in_future4", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "election_in_future5", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "election_in_future6", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "election_in_future7", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "election_in_future8", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "election_in_future9", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>

                    </div>

                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12">
                    <?php
                    echo Html::activeLabel($model, "major_deficiencies_applicant_competent_leadership")
                    //echo Html::error($model,'existing_member_role', ['class' => 'help-block']);  
                    ?>
                    <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                        <?php echo $form->field($model, "major_deficiencies_applicant_competent_leadership1", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "major_deficiencies_applicant_competent_leadership2", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "major_deficiencies_applicant_competent_leadership3", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "major_deficiencies_applicant_competent_leadership4", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "major_deficiencies_applicant_competent_leadership5", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "major_deficiencies_applicant_competent_leadership6", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "major_deficiencies_applicant_competent_leadership7", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "major_deficiencies_applicant_competent_leadership8", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>


                    </div>

                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "applicants_guess_their_role_as_wada_sakhi")->dropDownList(["1" => "जी नहीं", "2" => "जी हाँ", "3" => "पता नहीं, पर मैं सीख लूँगी", "4" => "जी हाँ, ऐप के शुरू में संक्षिप्त परिचय में बताया गया है"], ['prompt' => 'चयन कीजिए']) ?>
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
        $(".applicant_member_other_organization").css("display","none");
        $(".election_in_future").css("display","none");
        $(".officer").css("display","none");
    $("#applicationform-existing_member").on("change", function() {  
        if ($(this).val() === "1") {
        $(".officer").css("display","block");
        } else if ($(this).val() === "2") {
          $(".officer").css("display","none");
           $("#applicationform-officer1").prop('checked', false);
           $("#applicationform-officer2").prop('checked', false);
           $("#applicationform-officer3").prop('checked', false);
           $("#applicationform-officer4").prop('checked', false);
           $("#applicationform-officer5").prop('checked', false);
           $("#applicationform-officer6").prop('checked', false); 
           $("#applicationform-officer7").prop('checked', false);
           $("#applicationform-officer8").prop('checked', false);
           $("#applicationform-officer9").prop('checked', false);
           $("#applicationform-officer10").prop('checked', false);
           $("#applicationform-officer11").prop('checked', false);
           $("#applicationform-officer12").prop('checked', false);     
        } else{
         $(".officer").css("display","none");
           $("#applicationform-officer1").prop('checked', false);
           $("#applicationform-officer2").prop('checked', false);
           $("#applicationform-officer3").prop('checked', false);
           $("#applicationform-officer4").prop('checked', false);
           $("#applicationform-officer5").prop('checked', false);
           $("#applicationform-officer6").prop('checked', false); 
           $("#applicationform-officer7").prop('checked', false);
           $("#applicationform-officer8").prop('checked', false);
           $("#applicationform-officer9").prop('checked', false);
           $("#applicationform-officer10").prop('checked', false);
           $("#applicationform-officer11").prop('checked', false);
           $("#applicationform-officer12").prop('checked', false);  
        }
    });    
    $("#applicationform-applicant_member_other_organization").on("change", function() {
        if ($(this).val() === "1") {
             $(".applicant_member_other_organization").css("display","block");
             $(".field-applicationform-mobile_with_touch_use").css("display","block");
        } else if ($(this).val() === "2") {
            $(".applicant_member_other_organization").css("display","none");
            $(".election_in_future").css("display","block");
           $("#applicationform-applicant_member_other_organization1").prop('checked', false);
           $("#applicationform-applicant_member_other_organization2").prop('checked', false);
           $("#applicationform-applicant_member_other_organization3").prop('checked', false);
           $("#applicationform-applicant_member_other_organization4").prop('checked', false);
           $("#applicationform-applicant_member_other_organization5").prop('checked', false);
           $("#applicationform-applicant_member_other_organization6").prop('checked', false);
         } else{
           $("#applicationform-applicant_member_other_organization1").prop('checked', false);
           $("#applicationform-applicant_member_other_organization2").prop('checked', false);
           $("#applicationform-applicant_member_other_organization3").prop('checked', false);
           $("#applicationform-applicant_member_other_organization4").prop('checked', false);
           $("#applicationform-applicant_member_other_organization5").prop('checked', false);
           $("#applicationform-applicant_member_other_organization6").prop('checked', false);
           $("#applicationform-election_in_future1").prop('checked', false);
           $("#applicationform-election_in_future2").prop('checked', false);
           $("#applicationform-election_in_future3").prop('checked', false);
           $("#applicationform-election_in_future4").prop('checked', false);
           $("#applicationform-election_in_future5").prop('checked', false);
           $("#applicationform-election_in_future6").prop('checked', false); 
           $("#applicationform-election_in_future7").prop('checked', false);
           $("#applicationform-election_in_future8").prop('checked', false);
           $("#applicationform-election_in_future9").prop('checked', false);
           $("#applicationform-election_in_future")[0].selectedIndex = 0;    
           $(".applicant_member_other_organization").css("display","none");
           $(".election_in_future").css("display","none"); 
      }
  }); 
   $("#applicationform-election_in_future").on("change", function() {
        if ($(this).val() === "1") {
             $(".election_in_future_role").css("display","block");
             
        } else if ($(this).val() === "2") {
            $(".election_in_future_role").css("display","none");
           $("#applicationform-election_in_future1").prop('checked', false);
           $("#applicationform-election_in_future2").prop('checked', false);
           $("#applicationform-election_in_future3").prop('checked', false);
           $("#applicationform-election_in_future4").prop('checked', false);
           $("#applicationform-election_in_future5").prop('checked', false);
           $("#applicationform-election_in_future6").prop('checked', false); 
           $("#applicationform-election_in_future7").prop('checked', false);
           $("#applicationform-election_in_future8").prop('checked', false);
           $("#applicationform-election_in_future9").prop('checked', false);
         } else {
           $(".election_in_future_role").css("display","none");
           $("#applicationform-election_in_future1").prop('checked', false);
           $("#applicationform-election_in_future2").prop('checked', false);
           $("#applicationform-election_in_future3").prop('checked', false);
           $("#applicationform-election_in_future4").prop('checked', false);
           $("#applicationform-election_in_future5").prop('checked', false);
           $("#applicationform-election_in_future6").prop('checked', false); 
           $("#applicationform-election_in_future7").prop('checked', false);
           $("#applicationform-election_in_future8").prop('checked', false);
           $("#applicationform-election_in_future9").prop('checked', false);
          
      }
  });  
    });         
JS;
$this->registerJs($js);
?>