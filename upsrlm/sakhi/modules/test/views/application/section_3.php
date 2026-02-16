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
        Section 3 : टेक्नॉलजी पारंगतता
    </h3>
</div>
<br />
<div class="card">

    <div class="col-lg-12">

        <div class='card-body'>
            <?php $form = ActiveMobileForm::begin(['id' => 'form-shg-application_form', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>

            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "phone_type")->dropDownList(yii\helpers\ArrayHelper::map(\common\models\wada\master\WadaApplicationMasterPhoneType::find()->where(['status' => 1])->all(), 'id', 'name_hi'), ['prompt' => 'चयन कीजिए']) ?>
                </div>

                <div class="col-lg-12" id="mwtw">
                    <?php echo $form->field($model, "mobile_with_touch_whose")->dropDownList(yii\helpers\ArrayHelper::map(\common\models\wada\master\WadaApplicationMasterMobileWhose::find()->where(['status' => 1])->all(), 'id', 'name_hi'), ['prompt' => 'चयन कीजिए']) ?>
                </div>

                <div class="col-lg-12" id="mwtu">
                    <?= $form->field($model, "mobile_with_touch_use")->checkboxList(\yii\helpers\ArrayHelper::map(\common\models\wada\master\WadaApplicationMasterMobileUsed::find()->where(['status' => 1])->all(), 'id', 'name_hi')) ?>
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
        $(".field-applicationform-mobile_with_touch_whose").css("display","none");
        $(".field-applicationform-mobile_with_touch_use").css("display","none");
    $("#applicationform-phone_type").on("change", function() {
        if ($(this).val() === "1") {
             $(".field-applicationform-mobile_with_touch_whose").css("display","block");
             $(".field-applicationform-mobile_with_touch_use").css("display","block");
        } else{
            $("#applicationform-mobile_with_touch_whose")[0].selectedIndex = 0;
            $("#applicationform-mobile_with_touch_use")[0].selectedIndex = 0;
            $(".field-applicationform-mobile_with_touch_whose").css("display","none");
            $(".field-applicationform-mobile_with_touch_use").css("display","none"); 
      }
  }); 
    
    });         
JS;
$this->registerJs($js);
?>