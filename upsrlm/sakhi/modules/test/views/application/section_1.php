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
        document.getElementById('p-image').setAttribute('src', '/user/default/tempimg?file=' + data);
        document.getElementById('applicationform-profile_photo').setAttribute('value', data);
        //alert(data);
        $('#profile_photo_msg').text('');

    }

    function takePictureAadharf(outputFunction) {
        //alert(outputFunction);
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDataaf(data) {

        document.getElementById('af-image').setAttribute('src', '/user/default/tempimg?file=' + data);
        document.getElementById('applicationform-aadhar_front_photo').setAttribute('value', data);

    }

    function takePictureAadharb(outputFunction) {
        //alert(outputFunction);
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDataab(data) {
        document.getElementById('ab-image').setAttribute('src', '/user/default/tempimg?file=' + data);
        document.getElementById('applicationform-aadhar_back_photo').setAttribute('value', data);
        $('#aadhar_back_photo_msg').text('');
        // alert(data);
    }

    function takePicturePan(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDatapan(data) {
        document.getElementById('pan-image').setAttribute('src', '/user/default/tempimg?file=' + data);
        document.getElementById('applicationform-pan_photo').setAttribute('value', data);
        $('#pan_photo_msg').text('');
        // alert(data);

    }

    function takePicturePassbook(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDatapassbook(data) {
        document.getElementById('passbook-image').setAttribute('src', '/user/default/tempimg?file=' + data);
        document.getElementById('applicationform-passbook_photo').setAttribute('value', data);
        $('#passbook_photo_msg').text('');
        // alert(data);

    }
</script>
<script type="text/javascript">
//    jQuery(document).ready(function () {
//        jQuery(".phone").keypress(function (e) {
//            var length = jQuery(this).val().length;
//            if (length > 9) {
//                return false;
//            } else if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
//                return false;
//            } else if ((length == 0) && (e.which == 48)) {
//                return false;
//            }
//        });
//    });
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
            <!--            <label for="myfile">Select a file:</label>
                        <input type="file" id="myfile1" name="myfile1"><br/>
                        <label for="myfile">Select a file:</label>
                        <input type="file" id="myfile2" name="myfile2">
                        <label for="myfile">Select a file:</label>
                        <input type="file" id="myfile3" name="myfile3">-->
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

                    <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePictureAadharf(<?="'".$model->aadhar_front_photo_id."'"?>)">
                        <i class="fal fa-camera"></i> आधार फ्रंट फोटो अपलोड करें
                    </button>
                    <?= $form->field($model, 'aadhar_front_photo')->hiddenInput()->label('') ?>
                    <img id="af-image" src="" class="img-responsive" width="200" height="300" />

                    <span id="aadhar_front_photo_msg" class="d-block"></span>

                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">

                    <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePictureAadharb(<?="'".$model->aadhar_back_photo_id."'"?>)">
                        <i class="fal fa-camera"></i> आधार बैक फोटो अपलोड करें
                    </button>
                    <?= $form->field($model, 'aadhar_back_photo')->hiddenInput()->label('') ?>
                    <img id="ab-image" src="" class="img-responsive" width="200" height="300" />

                    <span id="aadhar_back_photo_msg" class="d-block"></span>

                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php echo $form->field($model, "pan_no")->textInput([]) ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">

                    <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePicturePan(<?="'".$model->pan_photo_id."'"?>)">
                        <i class="fal fa-camera"></i> पैन फोटो अपलोड करें
                    </button>
                    <?= $form->field($model, 'pan_photo')->hiddenInput()->label('') ?>
                    <img id="pan-image" src="" class="img-responsive" width="200" height="300" />

                    <span id="pan_photo_msg" class="d-block"></span>

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

                    <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePicturePassbook(<?="'".$model->passbook_photo_id."'"?>)">
                        <i class="fal fa-camera"></i> पासबुक फोटो अपलोड करें
                    </button>
                    <?= $form->field($model, 'passbook_photo')->hiddenInput()->label('') ?>
                    <img id="passbook-image" src="" class="img-responsive" width="200"/>

                    <span id="passbook_photo_msg" class="d-block"></span>

                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">

                    <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePictureProfile(<?="'".$model->profile_photo_id."'"?>)">
                        <i class="fal fa-camera"></i> प्रोफाइल फोटो अपलोड करें
                    </button><br>
                    <small>फोटो से फोटो न खींचे</small>
                    <?= $form->field($model, 'profile_photo')->hiddenInput()->label('') ?>
                    <img id="p-image" src="" class="img-responsive" width="200" height="300" />                   
                    <span id="profile_photo_msg" class="d-block"></span>
                </div>

            </div>
        </div>

        <div class="form-group text-center">
            <div style="display:none">
            <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label('') ?>
            <?= $form->field($model, 'profile_photo_id')->hiddenInput()->label('') ?>
            <?= $form->field($model, 'aadhar_front_photo_id')->hiddenInput()->label('') ?>
            <?= $form->field($model, 'aadhar_back_photo_id')->hiddenInput()->label('') ?>
            <?= $form->field($model, 'pan_photo_id')->hiddenInput()->label('') ?>
            <?= $form->field($model, 'passbook_photo_id')->hiddenInput()->label('') ?>
            </div>
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
//$js = <<<JS
// $(function () {       
//$('.saveimage').click(function(){                
//   var url=$(this).attr('url');
//   var file_name=$(this).attr('file_name');
//   var file=$(this).attr('file');  
//   var message=$(this).attr('file_name')+'_msg';    
//   var target_id=$(this).attr('target_id');    
//                   $.ajax({
//                        url: url,
//                        type: 'post',
//                        data: {
//                                file : file,
//                                file_name : file_name,
//                        },
//                        dataType: 'json',
//                        context: this,    
//                        success: function (data) {
//                               if(data.success === true){
//                                     $('#'+target_id).val('1');
//                                     $('#'+file_name).css('display','none');
//                                     $('#'+message).text('फोटो सेव हुआ');
//                                   }
//                            },
//                            error  : function (e)
//                            {
//                                console.log(e);
//                            }
//                           });
//                     
//   });                     
// }); 
//        
//JS;
//$this->registerJs($js);
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