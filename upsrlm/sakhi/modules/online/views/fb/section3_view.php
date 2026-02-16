<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = $name;
$app = new \sakhi\components\App();
$option = [];
?>
<div class='card'>
<div class="col-lg-12">
    <div class="text-center"> 
        <h3>
            <?= $this->title ?>
        </h3>
    </div>
</div>
    <div class="col-lg-12">

        <div class='card-body'>

            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec2_know_tele_medicine_through_live_video", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnof('sec2_know_tele_medicine_through_live_video') ?>
                    <?php
                    echo Html::activeLabel($model, "sec2_yes_used_tele_medicine_medium", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnof('sec2_yes_used_tele_medicine_medium') ?>
                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec2_aware_cost_medical_consultation_through_tele_medicine", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnof('sec2_aware_cost_medical_consultation_through_tele_medicine') ?>
                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec2_aware_cost_medical_consultation_through_tele_medicine", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnof('sec2_aware_cost_medical_consultation_through_tele_medicine') ?>
                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12"> 
                    <label class="bold_lable" name="sec2_explain_understanding_tele_medicine">2.5 टेली-मेडिसिन के बारे में अपनी समझ स्पष्ट करें (एक से ज़्यादा उत्तर में टिक कर सकते हैं)</label>
                    <?= $model->getSec2explainunderstandingtelemedicinehtml() ?> 




                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec2_strong_system_telemedicine_maximum_fee", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getSec2strongsystemtelemedicinemaximumfeef() ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec2_subsidy_by_government", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getSec2subsidybygovernmentf() ?>
                </div>
            </div>


            <div class="form-group text-center">

                <a href="<?= '/online/fb/form' ?>" class="btn btn-dark"><i class="fal fa fa-arrow-left" aria-hidden="true"></i><span> वापस</span> </a> 
            </div>     
        </div>
    </div>    
</div>  

<?php
$style1 = <<< CSS
 .card {
    margin-bottom: 5px !important;
}
.bold_lable {
  font-weight: bold !important;  
}
CSS;
$this->registerCss($style1);
?>
 