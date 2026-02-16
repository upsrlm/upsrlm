<?php

use yii\helpers\Html;
use kartik\password\PasswordInput;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\widgets\TouchSpin;
use kartik\widgets\FileInput;
use yii\bootstrap4\Modal;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

$style = <<< CSS
        .form-group {margin-bottom:5px;}
   .help-block {margin-top:3px;margin-bottom:3px;      }
    .form-horizontal .control-label {padding-top:0px;}
        .title {font-weight:bold; font-size:16px;}

CSS;
$this->registerCss($style);

$this->title = 'Profile Update';
if (Yii::$app->session->hasFlash('error')) {
    echo "<div class='alert alert-success'>" . Yii::$app->session->getFlash('error') . "</div>";
}
?>
<div class='profile-form' style="padding:0px 10px;background-color: white">

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8 panel-tag" style="text-align: left;font-size:16px;">
            प्रोफाइल पूरी तरह भरने के लिए निम्न दस्तावेजों की स्कैन कॉपी अपलोड करना आवश्यक है I दस्तावेज साफ़, स्पष्ट एवं सम्पूर्ण हो अन्यथा प्रोफाइल के सत्यापन में असुविधा होगी I <br/>
            1. HR/ मैनपावर मैनेजमेंट एजेंसी के द्वारा प्रदत्त ऑफर लेटर,  <br/>
            2. DMM एवं मैनपावर मैनेजमेंट एजेंसी के द्वारा हस्ताक्षरित 'सर्विस एग्रीमेंट', एवं  <br/>
            3. अद्यतन 'पोस्टिंग आर्डर' की स्कैन्ड प्रति  (जिन DMM के सर्विस एग्रीमेंट के बाद कोई और पोस्टिंग नहीं हुआ, वे अपना सर्विस एग्रीमेंट की प्रति दोबारा अपलोड कर दें - इसे खाली न छोड़े I)   <br/>
            किसी भी असुविधा या जानकारी के लिए 92609 85122 पर संपर्क कर सकते हैं I
        </div>
        <div class="col-md-2"></div>
    </div>

    <?php
    $form = ActiveForm::begin([
                'id' => 'profile-update-form',
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
                //'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
                'fieldConfig' => [
                    'template' => "<div class=\"col-lg-9\">{label}<br/>{input}<div>{error}</div></div>",
                //'labelOptions' => ['class' => 'col-md-3 control-label'],
                ],
    ]);
    ?>
    <div class='box bordered-box orange-border grey-background' style="padding:10px;margin:20px;background-color: #bbbbbb">       
        <div class='box-header box-main-header grey-background'>
            <div class='title'>
                <i class='icon-minus-sign'></i>
                Personal Information
            </div>

        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'first_name') ?>
                    <?= $form->field($model, 'middle_name') ?>
                    <?= $form->field($model, 'sur_name') ?>
                    <?= $form->field($model, 'father_name') ?>


                    <?= $form->field($model, 'gender')->radioList(['1' => "Male", '2' => 'Female']) ?>

                    <?=
                    $form->field($model, 'date_of_birth')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Select date ...', 'value' => ($model->date_of_birth != null and $model->date_of_birth != null) ? Yii::$app->formatter->asDatetime($model->date_of_birth, "php:d-m-Y") : ''],
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'autoclose' => true,
                            'changeMonth' => true,
                            'changeYear' => true,
                        // 'endDate' => date('d-m-Y', strtotime('-95 years')),
                        ],
                    ]);
                    ?>

                </div>
                <div class="col-md-6">

                    <?= $form->field($model, 'aadhaar_number') ?>
                    <?= $form->field($model, 'pan_number') ?>
                    <br/>
                    <br/>
                    <?php
                    echo yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Upload Profile photo', ['id' => 'upload-photo-' . $model->photo_profile, 'class' => 'btn btn-sm btn-info btn-block popb', 'value' => '/profile/uploadfile?userid=' . $model->user_id . '&file_type=1', 'style' => 'width:300px', 'title' => 'Upload Photo']);
                    // echo $form->field($model, 'photo_profile')->fileInput(['accept' => 'image/*'])->label('Upload Profile photo');
//                    if ($model->photo_profile == '') {
//                        
//                    } else {
//                        
//                    }
                    ?>
                    <br/>
                    <br/>

                    <?php
                    echo yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Upload photo of aadhaar card (front side)', ['id' => 'upload-photo-' . $model->photo_aadhaar_front, 'class' => 'btn btn-sm btn-info btn-block popb', 'value' => '/profile/uploadfile?userid=' . $model->user_id . '&file_type=3', 'style' => 'width:300px', 'title' => 'Upload Photo']);
//                    echo $form->field($model, 'photo_aadhaar_front')->fileInput(['accept' => 'image/*'])->label('Upload photo of aadhaar card (front side)');
//
//                    if ($model->photo_profile == '') {
//                        
//                    } else {
//                        echo $form->field($model, "change_profile")->checkbox(['label' => 'Change'])->label('');
//                    }
                    ?>
                    <br/>
                    <br/>
                    <?php
                    echo yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Upload photo of aadhaar card (back side)', ['id' => 'upload-photo-' . $model->photo_aadhaar_back, 'class' => 'btn btn-sm btn-info btn-block popb', 'value' => '/profile/uploadfile?userid=' . $model->user_id . '&file_type=4', 'style' => 'width:300px', 'title' => 'Upload Photo']);
//echo $form->field($model, 'photo_aadhaar_back')->fileInput(['accept' => 'image/*'])->label('Upload photo of aadhaar card (back side)');
//                    if ($model->photo_profile == '') {
//                        
//                    } else {
//                        echo $form->field($model, "change_profile")->checkbox(['label' => 'Change'])->label('');
//                    }
                    ?>

                    <br/>

                    <br/>

                    <?php
                    echo yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Upload photo of PAN card', ['id' => 'upload-photo-' . $model->photo_pan, 'class' => 'btn btn-sm btn-info btn-block popb', 'value' => '/profile/uploadfile?userid=' . $model->user_id . '&file_type=2', 'style' => 'width:300px', 'title' => 'Upload Photo']);
//echo $form->field($model, 'photo_pan')->fileInput(['accept' => 'image/*'])->label('Upload photo of PAN card');
//                    if ($model->photo_profile == '') {
//                        
//                    } else {
//                        echo $form->field($model, "change_profile")->checkbox(['label' => 'Change'])->label('');
//                    }
                    ?>


                </div>
            </div>
        </div>
    </div>

    <div class='box bordered-box orange-border grey-background' style="padding:10px;margin:20px;background-color: #bbbbbb">       
        <div class='box-header box-main-header grey-background'>
            <div class='title'>
                <i class='icon-minus-sign'></i>
                Contact Detail 
            </div>

        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'primary_phone_no') ?>
                    <?= $form->field($model, 'alternate_phone_no') ?>


                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'whatsapp_no') ?>
                    <?= $form->field($model, 'email_id') ?>


                </div>
            </div>
        </div>
    </div>

    <div class='box bordered-box orange-border grey-background' style="padding:10px;margin:20px;background-color: #bbbbbb">       
        <div class='box-header box-main-header grey-background'>
        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-6">
                    <div class='title'>
                        <i class='icon-minus-sign'></i>
                        Present Address
                    </div>

                    <?= $form->field($model, 'present_address_house_no') ?>
                    <?= $form->field($model, 'present_address_street_mohalla') ?>
                    <?= $form->field($model, 'present_address_postoffice') ?>
                    <?= $form->field($model, 'present_address_district') ?>
                    <?= $form->field($model, 'present_address_state') ?>

                </div>
                <div class="col-md-6">
                    <div class='title'>
                        <i class='icon-minus-sign'></i>
                        Permanent Address
                    </div>


                    <?= $form->field($model, 'permanent_address_house_no') ?>
                    <?= $form->field($model, 'permanent_address_street_mohalla') ?>
                    <?= $form->field($model, 'permanent_address_postoffice') ?>
                    <?= $form->field($model, 'permanent_address_district') ?>
                    <?= $form->field($model, 'permanent_address_state') ?>



                </div>
            </div>
        </div>
    </div>

    <div class='box bordered-box orange-border grey-background' style="padding:10px;margin:20px;background-color: #bbbbbb">       
        <div class='box-header box-main-header grey-background'>
            <div class='title'>
                <i class='icon-minus-sign'></i>
                Official Information
            </div>

        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'designation') ?>
                    <?=
                    $form->field($model, 'date_of_joining')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Select date ...', 'value' => ($model->date_of_joining != null and $model->date_of_joining != null) ? Yii::$app->formatter->asDatetime($model->date_of_joining, "php:d-m-Y") : ''],
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'autoclose' => true,
                            'changeMonth' => true,
                            'changeYear' => true,
                        //'endDate' => date('d-m-Y', strtotime('-15 years')),
                        ],
                    ]);
                    ?> 
                    <?php
                    echo yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Upload scanned copy of offer letter', ['id' => 'upload-photo-' . $model->photo_letter_of_appointment, 'class' => 'btn btn-sm btn-info btn-block popb', 'value' => '/profile/uploadfile?userid=' . $model->user_id . '&file_type=6', 'style' => 'width:300px', 'title' => 'Upload Photo']);
//                    echo $form->field($model, 'photo_letter_of_appointment')->fileInput(['accept' => 'image/*'])->label('Upload scanned copy of offer letter');
//
//                    if ($model->photo_profile == '') {
//                        
//                    } else {
//                        echo $form->field($model, "change_profile")->checkbox(['label' => 'Change'])->label('');
//                    }
                    ?>
                    <br/>
                    <br/>
                    <?php
                    echo yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Upload scanned copy of service agreement', ['id' => 'upload-photo-' . $model->photo_service_agreement, 'class' => 'btn btn-sm btn-info btn-block popb', 'value' => '/profile/uploadfile?userid=' . $model->user_id . '&file_type=7', 'style' => 'width:300px', 'title' => 'Upload Photo']);
//                    echo $form->field($model, 'photo_service_agreement')->fileInput(['accept' => 'image/*'])->label('Upload scanned copy of service agreement');
//
//                    if ($model->photo_profile == '') {
//                        
//                    } else {
//                        echo $form->field($model, "change_profile")->checkbox(['label' => 'Change'])->label('');
//                    }
                    ?>



                </div>
                <div class="col-md-6">



                    <?php
                    echo $form->field($model, 'posting_district_code')->widget(kartik\select2\Select2::classname(), [
                        'data' => $model->district_option,
                        'size' => Select2::MEDIUM,
                        'options' => ['placeholder' => 'Select District', 'multiple' => FALSE],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>

                    

                    <?php
//                    echo $form->field($model, 'posting_block_code')->widget(DepDrop::classname(), [
//                        'data' => $model->block_option,
//                        'options' => ['placeholder' => 'Select Block', 'multiple' => FALSE],
//                        'pluginOptions' => [
//                            'placeholder' => 'Select Block',
//                            'depends' => ['dmmu_profileform-posting_district_code'],
//                            'url' => Url::to(['/ajax/getblock']),
//                        ],
//                    ]);
                    ?> 

                    <?=
                    $form->field($model, 'date_of_last_posting')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Select date ...', 'value' => ($model->date_of_last_posting != null and $model->date_of_last_posting != null) ? Yii::$app->formatter->asDatetime($model->date_of_last_posting, "php:d-m-Y") : ''],
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'autoclose' => true,
                            'changeMonth' => true,
                            'changeYear' => true,
                        //'endDate' => date('d-m-Y', strtotime('-15 years')),
                        ],
                    ])->label('Current Posting Date');
                    ;
                    ?>
                    <?php
                    echo yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Upload last posting order', ['id' => 'upload-photo-' . $model->photo_letter_of_last_posting_order, 'class' => 'btn btn-sm btn-info btn-block popb', 'value' => '/profile/uploadfile?userid=' . $model->user_id . '&file_type=8', 'style' => 'width:300px', 'title' => 'Upload Photo']);
//                    echo $form->field($model, 'photo_letter_of_last_posting_order')->fileInput(['accept' => 'image/*'])->label('Upload last posting order');
//
//                    if ($model->photo_profile == '') {
//                        
//                    } else {
//                        echo $form->field($model, "change_profile")->checkbox(['label' => 'Change'])->label('');
//                    }
//                    
                    ?>


                </div>
            </div>
        </div>
    </div>


    <div class='box bordered-box orange-border grey-background' style="padding:10px;margin:20px;background-color: #bbbbbb">       
        <div class='box-header box-main-header grey-background'>
            <div class='title'>
                <i class='icon-minus-sign'></i>
                Salary Bank Account Detail            </div>

        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'bank_name') ?>
                    <?= $form->field($model, 'bank_branch') ?>
                    <?php
                    echo yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Upload photo of first page of bank passbook', ['id' => 'upload-photo-' . $model->photo_bank_passbook, 'class' => 'btn btn-sm btn-info btn-block popb', 'value' => '/profile/uploadfile?userid=' . $model->user_id . '&file_type=5', 'style' => 'width:300px', 'title' => 'Upload Photo']);
                    ?>
                </div>
                <div class="col-md-6">



                    <?= $form->field($model, 'bank_account_number') ?>
                    <?= $form->field($model, 'bank_ifsc_code') ?>



                </div>
            </div>
        </div>
    </div>
     <div class='box bordered-box orange-border grey-background' style="padding:10px;margin:20px;background-color: #bbbbbb">       
        <div class='box-header box-main-header grey-background'>
            <div class='title'>
                <i class='icon-minus-sign'></i>
                Brief professional profile            </div>

        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'brief_professional_profile')->textarea() ?>
                    <?= $form->field($model, 'academic_qualification_awards')->textarea() ?>
                    
                </div>
                <div class="col-md-6">

                    <?= $form->field($model, 'professional_training')->textarea() ?>
                    <?= $form->field($model, 'experience')->textarea() ?>

                </div>
                 <div class="col-md-6">

                    <?= $form->field($model, 'professional_association')->textarea() ?>
                    

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="col-md-3">
            <?php
            if ($model->profle_model->chcekProfileStatus() == "1") {
                echo Html::a('<i class="fa fa-thumb-up"></i> Submit the Profile', '/profile/view', ['id' => 'view-button', 'class' => 'btn btn-sm btn-success btn-block', 'style' => 'width:300px', 'title' => '']);
            } else {
                echo Html::a('<i class="fa fa-thumb-up"></i> View the Profile', '/profile/view', ['id' => 'view-button', 'class' => 'btn btn-sm btn-success btn-block', 'style' => 'width:300px', 'title' => '']);
               
                } ?>
            </div>
            <div class="col-md-3"></div>
        </div>
    <?php ActiveForm::end(); ?>
    </div>


    <?php
    $Js = '

$(document).ready(function(){
   $(".box-main-header").on("click",function(){
   $(".box-status").slideUp();
   if($(".box-status").is(":hidden"))
   {
   $(".box-main-header i").attr("class","icon-plus-sign");
   }
   $(this).children().children("i").attr("class","icon-minus-sign")
   if($(this).parent().children(".box-status").is(":visible"))
   {
   $(this).children().children("i").attr("class","icon-plus-sign")
   }
   else
   {
   $(this).parent().children(".box-status").slideToggle();
   }    
   })     
   })
   ;';
    $this->registerJs($Js);
    ?>
    <?php
    $js = <<<JS
$(function () {
         
    $('.popb').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
               .find('#iframeimagecontent').attr('src',$(this).attr('value'))     
        // .find('#imagecontent')
         //.load($(this).attr('value'));
         document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';     
        });
});  
        
JS;
    $this->registerJs($js);
    ?> 
    <?php
    Modal::begin([
        'headerOptions' => ['id' => 'modalHeader'],
        'id' => 'modal',
        'size' => 'modal-lg',
//    'options' => ['data-backdrop' => 'true',],
        'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
        ],
    ]);
    echo "<div id='imagecontent'></div>";
    echo "<iframe id='iframeimagecontent' style='width:100%;border:0px;height:300px;'></iframe>";
    Modal::end();
    ?>           