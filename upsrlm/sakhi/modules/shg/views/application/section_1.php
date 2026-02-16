<?php

use yii\bootstrap4\Html;
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
$mobile = new \sakhi\components\MobileDetect();
?>
<script type="text/javascript">
    var date = <?= isset($model->dob) ? strtotime($model->dob) . '000' : 0 ?>;
    var mindate = <?= strtotime('1960-01-01') . '000' ?>;
    var maxdate = <?= strtotime('2004-01-01') . '000' ?>;

    function takePictureProfile(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDatap(data) {
        document.getElementById('p-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('profile_photo').setAttribute('file', data);
        $('#profile_photo').css('display', 'block');
        $('#profile_photo_msg').text('');
        document.getElementById('applicationform-profile_photo').setAttribute('value', '');
        if (typeof AndroidDevice !== "undefined") {
        }
    }

    function takePictureAadharf(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDataaf(data) {
        document.getElementById('af-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('aadhar_front_photo').setAttribute('file', data);
        $('#aadhar_front_photo').css('display', 'block');
        $('#aadhar_front_photo_msg').text('');
       document.getElementById('applicationform-aadhar_front_photo').setAttribute('value', '');
        if (typeof AndroidDevice !== "undefined") {
        }
    }

    function takePictureAadharb(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDataab(data) {
        document.getElementById('ab-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('aadhar_back_photo').setAttribute('file', data);
        $('#aadhar_back_photo').css('display', 'block');
        $('#aadhar_back_photo_msg').text('');
        document.getElementById('applicationform-aadhar_back_photo').setAttribute('value', '');
        if (typeof AndroidDevice !== "undefined") {
        }
    }

    function takePicturePan(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDatapan(data) {
        //alert("fff");
        document.getElementById('pan-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('pan_photo').setAttribute('file', data);
        $('#pan_photo').css('display', 'block');
        $('#pan_photo_msg').text('');
        document.getElementById('applicationform-pan_photo').setAttribute('value', '');
        //if (typeof AndroidDevice !== "undefined") {
        //}
    }

    function takePicturePassbook(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDatapassbook(data) {
        document.getElementById('passbook-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('passbook_photo').setAttribute('file', data);
        $('#passbook_photo').css('display', 'block');
        $('#passbook_photo_msg').text('');
        document.getElementById('applicationform-passbook_photo').setAttribute('value', '');
        if (typeof AndroidDevice !== "undefined") {
        }
    }
</script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery(".phone").keypress(function (e) {
            var length = jQuery(this).val().length;
            if (length > 9) {
                return false;
            } else if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            } else if ((length == 0) && (e.which == 48)) {
                return false;
            }
        });
    });
</script>
<div class="subheader" style="text-align: center">
    <h3 class="subheader-title">
        Section 1 : बेसिक सूचना
    </h3>
</div>
<br />

<div class="card">

    <div class="col-lg-12">

        <div class='card-body'>
            <?php $form = ActiveMobileForm::begin(['id' => 'form-shg-application_form', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "name")->textInput(['readonly' => true]) ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "shg_name")->textInput(['readonly' => true]) ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "mobile_number")->textInput(['type' => 'number', 'readonly' => true]) ?>
                </div>
            </div>

            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "alt_mobile_number")->textInput(['type' => 'number', 'class' => 'phone', 'pattern' => "[1-9]{1}[0-9]{9}"]) ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "whatsapp_number")->textInput(['type' => 'number', 'class' => 'phone', 'pattern' => "[1-9]{1}[0-9]{9}"]) ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?=
                    $form->field($model, 'dob', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fal fa-calendar-alt text-primary"></i> </span>
    </div>{input}</div>',
                    ])->hint('जन्म तिथि आधार कार्ड के समान हो')->textInput(['placeholder' => 'जन्म तिथि', 'onclick' => "javascript:return showCalender(date,mindate,maxdate,'applicationform-dob');"])->label('6. जन्म तिथि ')
                    ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "guardian_name")->textInput([]) ?>
                </div>
            </div>

            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "academic_level")->dropDownList(yii\helpers\ArrayHelper::map(WadaApplicationMasterEducationalLevel::find()->where(['status' => 1])->all(), 'id', 'name_hi'), ['prompt' => 'चयन कीजिए']) ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "vocational_professional_training")->checkboxList(\yii\helpers\ArrayHelper::map(\common\models\wada\master\WadaApplicationMasterVocationalTraining::find()->where(['status' => 1])->all(), 'id', 'name_hi')) ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "social_class")->dropDownList(yii\helpers\ArrayHelper::map(WadaApplicationMasterCast::find()->where(['status' => 1])->all(), 'id', 'name_hi'), ['prompt' => 'चयन कीजिए']) ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "marital_status")->dropDownList(yii\helpers\ArrayHelper::map(WadaApplicationMasterMarriageStatus::find()->where(['status' => 1])->all(), 'id', 'name_hi'), ['prompt' => 'चयन कीजिए']) ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php
                    echo Html::activeLabel($model, "house_member_details")
                    ?>
                    <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                        <?php echo $form->field($model, "house_member_details1")->textInput(['type' => 'number', 'min' => 0, 'max' => 5, 'pattern' => "[0-5]{1}"]) ?>
                        <?php echo $form->field($model, "house_member_details2")->textInput(['type' => 'number', 'min' => 0, 'max' => 5, 'pattern' => "[0-5]{1}"]) ?>
                        <?php echo $form->field($model, "house_member_details3")->textInput(['type' => 'number', 'min' => 0, 'max' => 5, 'pattern' => "[0-5]{1}"]) ?>
                        <?php echo $form->field($model, "house_member_details4")->textInput(['type' => 'number', 'min' => 0, 'max' => 5, 'pattern' => "[0-5]{1}"]) ?>

                    </div>

                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "aadhar_number")->textInput(['type' => 'number']) ?>

                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php if (!$mobile->isAndroidOS()) { ?>

                        <img src='data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMfaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjc1MkU3OTlERUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjc1MkU3OTlDRUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJCMTYxREI0NDRGRUQ5RUFBNDU3RDU4RDQyNjBFNkVEQyIgc3RSZWY6ZG9jdW1lbnRJRD0iQjE2MURCNDQ0RkVEOUVBQTQ1N0Q1OEQ0MjYwRTZFREMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYGCAsMCgoLCgoMEAwM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'/>
                        <button id="aadhar_front_photo" file_name="aadhar_front_photo" target_id="applicationform-aadhar_front_photo" url="<?= \Yii::$app->params['app_url']['sakhi'] . '/shg/application/saveimage?shgid=' . $model->cbo_shg_id ?>" class="saveimage btn btn-sm btn-info" shg="<?= $model->cbo_shg_id ?>" file="/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMfaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjc1MkU3OTlERUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjc1MkU3OTlDRUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJCMTYxREI0NDRGRUQ5RUFBNDU3RDU4RDQyNjBFNkVEQyIgc3RSZWY6ZG9jdW1lbnRJRD0iQjE2MURCNDQ0RkVEOUVBQTQ1N0Q1OEQ0MjYwRTZFREMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYGCAsMCgoLCgoMEAwM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" type="button">आधार फ्रंट फोटो सेव करें</button>;
                        <?= $form->field($model, 'aadhar_front_photo')->hiddenInput()->label('') ?>
                    <?php } else {
                        ?>
                        <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePictureAadharf('imageDataaf')">
                            <i class="fal fa-camera"></i> आधार फ्रंट फोटो अपलोड करें
                        </button>
                        <?= $form->field($model, 'aadhar_front_photo')->hiddenInput()->label('') ?>
                        <img id="af-image" src="" class="img-responsive" width="200" height="300" />
                        <button id="aadhar_front_photo" file_name="aadhar_front_photo" target_id="applicationform-aadhar_front_photo" url="<?= \Yii::$app->params['app_url']['sakhi'] . '/shg/application/saveimage?shgid=' . $model->cbo_shg_id ?>" class="saveimage btn btn-sm btn-info" shg="<?= $model->cbo_shg_id ?>" file="" type="button">आधार फ्रंट फोटो सेव करें</button>
                       <span id="aadhar_front_photo_msg" class="d-block"></span>
                      <?php } ?>  
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php if (!$mobile->isAndroidOS()) { ?>
                        <img src='data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMfaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjc1MkU3OTlERUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjc1MkU3OTlDRUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJCMTYxREI0NDRGRUQ5RUFBNDU3RDU4RDQyNjBFNkVEQyIgc3RSZWY6ZG9jdW1lbnRJRD0iQjE2MURCNDQ0RkVEOUVBQTQ1N0Q1OEQ0MjYwRTZFREMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYGCAsMCgoLCgoMEAwM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'/>
                        <button id="aadhar_back_photo" file_name="aadhar_back_photo" target_id="applicationform-aadhar_back_photo" url="<?= \Yii::$app->params['app_url']['sakhi'] . '/shg/application/saveimage?shgid=' . $model->cbo_shg_id ?>" class="saveimage btn btn-sm btn-info" shg="<?= $model->cbo_shg_id ?>" file="/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMfaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjc1MkU3OTlERUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjc1MkU3OTlDRUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJCMTYxREI0NDRGRUQ5RUFBNDU3RDU4RDQyNjBFNkVEQyIgc3RSZWY6ZG9jdW1lbnRJRD0iQjE2MURCNDQ0RkVEOUVBQTQ1N0Q1OEQ0MjYwRTZFREMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYGCAsMCgoLCgoMEAwMDAwMDBAMDg8QDw4MExMUFBMTHBsbGxwfHx8fHx8fHx8fAQcHBw0MDRgQEBgaFREVGh8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx//wAARCABAAEADAREAAhEBAxEB/8QAkgAAAgIDAQEAAAAAAAAAAAAABgcFCAEDBAIJAQACAwEBAAAAAAAAAAAAAAADBAECBQAGEAACAQMCBQMCBAMJAQAAAAABAgMRBAUABiESIhMHMUEUUXFhMkIjgaFykVKSojNjJCU1CBEAAQQBAwIFAwUBAAAAAAAAAQARAgMhMRIEQVFhcSIyBfCR0YGhwUIjE//aAAwDAQACEQMRAD8AtLqFCw6K6MjflcFWoacCKHiNQuQVvG4xO2JYMtLem2tnie3kxzKGjnPMrmaoHc7w5QAeanGp1QxbRcIE6JSeSd9wb2jtxaqbWKzDlQKSB7hqBGelOlQDw99DuqM9VM+MZdUBXV1uS5tI4Ir1b22Vk+TYxxPA8YAPdmQTAEAcoICtQfTS0qW8uiXt4swC2Qoe8tcraW8GTwL3BfI3DQWlzKQs857PWAVqeERJY8OHD8NWhWZF+iVjAyL9FqlyFvDZvi72ygus9dWjKXkpFBiki/cX4bKzxytKvF5G41PL9dHLFMSAPZDF/i40t7TKTyC6sb5ElMUTxNJbF2KckkYJ5WJWqq54jUgNgKwhtZl9EtHR15lkWKJ5W/LGpZqfRRU65cqg+c/KD57OzLiQ99Z2f7Ub9s9qPjQ8K9RP97RAG1R4RLYCW2I3xcQuI5bEJKRys8QKCRT+l04j7N7HVJjxRYE6EKYj8gy2xAgkeWMUbmcAGMk8UZfUUPqBw+mgyqdXFgCJNh73w4jzlhNZI1jloHkvEtl7V+eagkFvOAxjVlVuFKcSTqIgxDFK8iI90VybT25gcndWV1uS5jxWOvmlktLGY/FWa0jRzCBkqmJKPH1pSv14karCIBykoRA1W7cGN2bl7vMyYu2ZHMlulph8ZYywrfQQRKLmR2CmaGKIqSWZAzt7aIC+iID2V0tEREA+d8zlcP4uzF9jiVdVRLmVfzRwOwV2H3ry/wAdWjqrR1SY2jhrQbIxkxhTvZSP5lxwHFpCaD7ADSHLnla3ECxfeM8begyxQiKQ/rUU0nvknxYHWo+AcdkbeTvzPFckDtXKL6fdffRIXWRQrRXIuYpcnZuV8eeT8TaZSzGYsruQdmJULx3sLgoYmQ0qQxHMpP8ALWhXdvi/ULK5FWw40KMZvGku5rC+s2scVjMxBJ865FtHL8fskIIorW3iVltVfuEuyFwzJTgeGp34xqs8SLJg7W/+e8JtewN9mVuLnI3E/wAGS7tclNY89pcSqVmml5oHDBSY2iBIbhwrx1xkRkqcjVP/AERWQ95E26m5NiZ3BsxT51nKiMPUOo50/wAyjXBWicqt2F3bBt/xztlriD5t9PbyRwwiRYkSK3dg8s0r9KItNK3VbpOVo8eRZgtO1vND5bOxYpbNYflP2baRJRJG8lfQMVX+3S9tBhF05TZGZZdG8N/eTMZutsDjYCiRAFjbxpJMykDqV5ysQH2B1Woxb1Fj4q9lZYGIJHh/Kn4r3N5PFYjO5qJzd4DJwOLm8gWGUQTt2blJEQsjlBysroaHXV2ASKBbSZtEayTByHkizx1jc2GIX4rIwWxaSPlQQueUFEqv5TX1+/HjpiXIx6cdlhksWQBuXzDNLcpaGYXuOqI7tJUR4C0dOoji9O4OZDXpI5q+mlbL5nQuqGTqx+tZEWRT39NcuVecj4/xOQiXE56MK2NurlG5KIrK85lQhRwINQaemkLpyxlitqvbuO0emTH6/VcOQ29s7G34SK5576CMTd6YgiGFGB6KBUU19gKnSkj0daMNxDkYRXnczgPhpk2s4cyY1SaWJVVpkipR5o6g1C0qR766RHmohWXYnau+Lce2s/hY3s3jeznUda05ORCCf8NOOucEtol5wNZftlJ3f+e+Tkri4ivLgwPKLBJkSVYlkQHliYTqOLKBQhSQorpq2JdwXHULy05SMidXKW0kd1Y3wlueV7ZEMn/HjkIkaopG54cobm/Vw+uujtnHGD4qITicq/aZTGOGKXkDhRzMVlQ0B9zx9NOf9Y9x90w61yZzCR/6mRtU/qmjHqKj1OoN9Y/sPuo3BKPzgbe3exzOOvlf5UgW6SJlaiqtFccv6WAIqfemg8moyjvHt7rR4HIiJbeqTd/jcozyW+XhiyOHyUnejyAlZkqB+2pRFMi9PpT39dJQkBkYktsGVhZtw7BHu38NJbYU2WGdorqZDFFdzQO8MY9AxNyyO4Xj0hNcQxd3VJAy1jtA7nP2C4VtsNs/H32PkuXZZ5Xe7u5RVVE4EUk7pHQIg5qsF1aiqV1jafwkOZeIVFvp1w3HhTJwStePn7cmMxlJmExeSIrSZCY+rqUDt0PAa1R8dMBnH11XmY2jxUVmPHW6cGk15b2dxmsZIxuGWzCSxxr+avaFJQUPHip/lrPt+OvHQY6g6oEySwGvdDezxu7emRlxuMEUMUAEuRyM7SLb28RNAWC9Ts1OlF4n8BqafiISOArSpAGSUzrPbO1NvRdyrZjJrwN5cjnRD/tW680Y/DmLHWxx/iqK9YiR8kHaAoHdN2MzaqOZu3A0khSRiHZoomdWCLSgFARXWpsBG06FQLTE7o6xQhsbeVmluuN3A7w2VxUR3fqkci8GB+lTryvI43qLajovYUckgCXQ9U0MZn9iYKP511nWuRyc0YklBUU4BQg410rGok6Ju68kZUHhckd7ZnMkRf8AWNYyxkMtC/yDyhWH9AJ1sfGUgEyPl+VgfKWEREepz+FOWkGYxGMgxHMt5DZW57MkjESGFTSKnr6J0n7a2gAcrFMiprAbqeOxiE55QsjIrR9RAXq560BpQ/w1EosujIFL3xVE+I8eQ3BP/p3L3t1FT1hDCGE196chqPodA4sPR5ovJn6vJEEzcrFV4KSaU9mU1BGmUB8oJ3plsni8XdZDGkRXsY7UcpQNypL+25CsD1crUGptcQLaqKGNoB0KDLO6xt3E0nPyxXdGyVo69VtOAF7qU4PDIR6j8p9dYnNqlL/SPuGq9B8feIf5T9p9v4WuLbkEl/b2sCpJPPKscLAAsxb0Cg8K6UrslMiPdaFtUa4mbPtU1Bv7d+zM3LHi7eIYmwCLd4ydQ/yHJ6nlkXrWQ+3KaLwGtiNRqDR0C8+bRed0/dL9m6IxufIMmei25lJMe2IuGMkbqsvdja1mPQCSFYda1GnqQTHPVZvIkIzx0UlHdMIUtu4BLeSyqhH6UL1dv4AasRnyVQWHmV//2Q==" type="button">आधार बैक फोटो सेव करें</button>;

                        <?= $form->field($model, 'aadhar_back_photo')->hiddenInput()->label('') ?>
                    <?php } else {
                        ?>
                        <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePictureAadharb('imageDataab')">
                            <i class="fal fa-camera"></i> आधार बैक फोटो अपलोड करें
                        </button>
                        <?= $form->field($model, 'aadhar_back_photo')->hiddenInput()->label('') ?>
                        <img id="ab-image" src="" class="img-responsive" width="200" height="300" />
                        <button id="aadhar_back_photo" file_name="aadhar_back_photo" target_id="applicationform-aadhar_back_photo" url="<?= \Yii::$app->params['app_url']['sakhi'] . '/shg/application/saveimage?shgid=' . $model->cbo_shg_id ?>" class="saveimage btn btn-sm btn-info" shg="<?= $model->cbo_shg_id ?>" file="" type="button">आधार बैक फोटो सेव करें</button>
                        <span id="aadhar_back_photo_msg" class="d-block"></span>
                    <?php } ?> 
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "pan_no")->textInput([]) ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php if (!$mobile->isAndroidOS()) { ?>
                        <img src='data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMfaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjc1MkU3OTlERUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjc1MkU3OTlDRUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJCMTYxREI0NDRGRUQ5RUFBNDU3RDU4RDQyNjBFNkVEQyIgc3RSZWY6ZG9jdW1lbnRJRD0iQjE2MURCNDQ0RkVEOUVBQTQ1N0Q1OEQ0MjYwRTZFREMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYGCAsMCgoLCgoMEAwM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'/>
                        <button id="pan_photo" file_name="pan_photo" target_id="applicationform-pan_photo" url="<?= \Yii::$app->params['app_url']['sakhi'] . '/shg/application/saveimage?shgid=' . $model->cbo_shg_id ?>" class="saveimage btn btn-sm btn-info" shg="<?= $model->cbo_shg_id ?>" file="/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMfaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjc1MkU3OTlERUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjc1MkU3OTlDRUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJCMTYxREI0NDRGRUQ5RUFBNDU3RDU4RDQyNjBFNkVEQyIgc3RSZWY6ZG9jdW1lbnRJRD0iQjE2MURCNDQ0RkVEOUVBQTQ1N0Q1OEQ0MjYwRTZFREMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYGCAsMCgoLCgoMEAwM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" type="button">पैन फोटो सेव करें</button>
                        <?= $form->field($model, 'pan_photo')->hiddenInput()->label('') ?>
                    <?php } else {
                        ?>
                        <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePicturePan('imageDatapan')">
                            <i class="fal fa-camera"></i> पैन फोटो अपलोड करें
                        </button>
                        <?= $form->field($model, 'pan_photo')->hiddenInput()->label('') ?>
                        <img id="pan-image" src="" class="img-responsive" width="200" height="300" />
                        <button id="pan_photo" file_name="pan_photo" target_id="applicationform-pan_photo" url="<?= \Yii::$app->params['app_url']['sakhi'] . '/shg/application/saveimage?shgid=' . $model->cbo_shg_id ?>" class="saveimage btn btn-sm btn-info" shg="<?= $model->cbo_shg_id ?>" file="" type="button">पैन फोटो सेव करें</button>
                        <span id="pan_photo_msg" class="d-block"></span>
                      <?php } ?> 
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "bank_account_no")->textInput(['type' => 'number']) ?>

                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "bank_id")->dropDownList(yii\helpers\ArrayHelper::map(cbo\models\master\CboMasterBank::find()->where(['status' => 1])->all(), 'id', 'bank_name'), ['prompt' => 'चयन कीजिए']) ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "branch")->textInput([]) ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "branch_code_or_ifsc")->textInput([]) ?>

                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php if (!$mobile->isAndroidOS()) { ?>
                        <img id="profile_photo" src='data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMfaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjc1MkU3OTlERUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjc1MkU3OTlDRUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJCMTYxREI0NDRGRUQ5RUFBNDU3RDU4RDQyNjBFNkVEQyIgc3RSZWY6ZG9jdW1lbnRJRD0iQjE2MURCNDQ0RkVEOUVBQTQ1N0Q1OEQ0MjYwRTZFREMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYGCAsMCgoLCgoMEAwM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'/>;
                        <button file_name="passbook_photo" target_id="applicationform-passbook_photo" url="<?= \Yii::$app->params['app_url']['sakhi'] . '/shg/application/saveimage?shgid=' . $model->cbo_shg_id ?>" class="saveimage btn btn-sm btn-info" shg="<?= $model->cbo_shg_id ?>" file="/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMfaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjc1MkU3OTlERUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjc1MkU3OTlDRUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJCMTYxREI0NDRGRUQ5RUFBNDU3RDU4RDQyNjBFNkVEQyIgc3RSZWY6ZG9jdW1lbnRJRD0iQjE2MURCNDQ0RkVEOUVBQTQ1N0Q1OEQ0MjYwRTZFREMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYGCAsMCgoLCgoMEAwM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" type="button">पासबुक फोटो सेव करें</button>
                        <?= $form->field($model, 'passbook_photo')->hiddenInput()->label('') ?>
                    <?php } else {
                        ?>
                        <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePicturePassbook('imageDatapassbook')">
                            <i class="fal fa-camera"></i> पासबुक फोटो अपलोड करें
                        </button>
                        <?= $form->field($model, 'passbook_photo')->hiddenInput()->label('') ?>
                        <img id="passbook-image" src="" class="img-responsive" width="200" height="300" />
                        <button id="passbook_photo" file_name="passbook_photo" target_id="applicationform-passbook_photo" url="<?= \Yii::$app->params['app_url']['sakhi'] . '/shg/application/saveimage?shgid=' . $model->cbo_shg_id ?>" class="saveimage btn btn-sm btn-info" shg="<?= $model->cbo_shg_id ?>" file="" type="button">पासबुक फोटो सेव करें</button>
                        <span id="passbook_photo_msg" class="d-block"></span>
                       <?php } ?> 
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php if (!$mobile->isAndroidOS()) { ?>
                        <img src='data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMfaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjc1MkU3OTlERUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjc1MkU3OTlDRUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJCMTYxREI0NDRGRUQ5RUFBNDU3RDU4RDQyNjBFNkVEQyIgc3RSZWY6ZG9jdW1lbnRJRD0iQjE2MURCNDQ0RkVEOUVBQTQ1N0Q1OEQ0MjYwRTZFREMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYGCAsMCgoLCgoMEAwM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'/>
                        <button id="profile_photo" file_name="profile_photo" target_id="applicationform-profile_photo" url="<?= \Yii::$app->params['app_url']['sakhi'] . '/shg/application/saveimage?shgid=' . $model->cbo_shg_id ?>" class="saveimage btn btn-sm btn-info" shg="<?= $model->cbo_shg_id ?>" file="/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMfaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjc1MkU3OTlERUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjc1MkU3OTlDRUNFMzExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJCMTYxREI0NDRGRUQ5RUFBNDU3RDU4RDQyNjBFNkVEQyIgc3RSZWY6ZG9jdW1lbnRJRD0iQjE2MURCNDQ0RkVEOUVBQTQ1N0Q1OEQ0MjYwRTZFREMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYGCAsMCgoLCgoMEAwM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" type="button">प्रोफाइल फोटो सेव करें</button>
                        <?= $form->field($model, 'profile_photo')->hiddenInput()->label('') ?>
                    <?php } else {
                        ?>
                        <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePictureProfile('imageDatap')">
                            <i class="fal fa-camera"></i> प्रोफाइल फोटो अपलोड करें
                        </button><br>
                        <small>फोटो से फोटो न खींचे</small>
                        <?= $form->field($model, 'profile_photo')->hiddenInput()->label('') ?>
                        <img id="p-image" src="" class="img-responsive" width="200" height="300" /> 
                        
                        <button id="profile_photo" file_name="profile_photo" target_id="applicationform-profile_photo" url="<?= \Yii::$app->params['app_url']['sakhi'] . '/shg/application/saveimage?shgid=' . $model->cbo_shg_id ?>" class="saveimage btn btn-sm btn-info" shg="<?= $model->cbo_shg_id ?>" file="" type="button">प्रोफाइल फोटो सेव करें</button>
                        <span id="profile_photo_msg" class="d-block"></span>
                    </div>
                <?php } ?> 
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
<?php
$style = <<< CSS
 img[src=""] {
        display: none;
    }  
  button[file=""] {
        display: none;
    }      
CSS;
$this->registerCss($style);
?>
<?php
$js = <<<JS
 $(function () {       
$('.saveimage').click(function(){                
   var url=$(this).attr('url');
   var file_name=$(this).attr('file_name');
   var file=$(this).attr('file');  
   var message=$(this).attr('file_name')+'_msg';    
   var target_id=$(this).attr('target_id');    
                   $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                                file : file,
                                file_name : file_name,
                        },
                        dataType: 'json',
                        context: this,    
                        success: function (data) {
                               if(data.success === true){
                                     $('#'+target_id).val('1');
                                     $('#'+file_name).css('display','none');
                                     $('#'+message).text('फोटो सेव हुआ');
                                   }
                            },
                            error  : function (e)
                            {
                                console.log(e);
                            }
                           });
                     
   });                     
 }); 
        
JS;
$this->registerJs($js);
?> `
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