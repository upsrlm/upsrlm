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
        Section 2 : Mobility
    </h3>
</div>
<br/>
<div class="card">

    <div class="col-lg-12">

        <div class='card-body'>
            <?php $form = ActiveMobileForm::begin(['id' => 'form-shg-application_form', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  


            <div class='card'>
                <div class="col-lg-12">  
                    <?php
                    echo Html::activeLabel($model, "travel_within_gp");

                    echo Html::error($model, 'travel_within_gp', ['class' => 'invalid-feedback']);
                    ?>
                    <div style="display:none">
                        <?= Html::activeTextInput($model, 'travel_within_gp'); ?> 
                    </div>
                    <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                        <?php echo $form->field($model, "travel_within_gp1", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "travel_within_gp2", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "travel_within_gp3", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "travel_within_gp4", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "travel_within_gp5", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "travel_within_gp6", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "travel_within_gp7", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "travel_within_gp8", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "travel_within_gp9", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "travel_within_gp10", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>



                    </div>

                </div>
            </div>

            <div class='card'>
                <div class="col-lg-12">  
                    <?php
                    echo Html::activeLabel($model, "vehicle_drive")
                    //echo Html::error($model,'existing_member_role', ['class' => 'help-block']);  
                    ?>
                    <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                        <?php echo $form->field($model, "vehicle_drive1", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "vehicle_drive2", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "vehicle_drive3", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "vehicle_drive4", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "vehicle_drive5", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>
                        <?php echo $form->field($model, "vehicle_drive6", ['options' => ['style' => 'margin-bottom:2px']])->checkbox() ?>


                    </div>

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
    .col-lg-12{
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }
    .card  .card-body {
        padding: 0px
    }
    .card-body .card {
        margin: 5px 0px
    }
    .card-body .card > :last-child, .card-group > :last-child {
        margin-bottom: 10px;
        margin-top:5px;
    }
    .form-group:last-child, .form-group:only-child {
        margin-bottom: 10px;
    }
</style>