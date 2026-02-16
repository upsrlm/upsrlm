<?php

use yii\helpers\Html;
use kartik\password\PasswordInput;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\widgets\TouchSpin;
use kartik\widgets\FileInput;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;
use yii\helpers\Url;

$style = <<< CSS
        .form-group {margin-bottom:5px;}
   .help-block {margin-top:3px;margin-bottom:3px;      }
    .form-horizontal .control-label {padding-top:0px;}
        .title {font-weight:bold; font-size:16px;}

CSS;
$this->registerCss($style);

$this->title = 'Profile View';
if (Yii::$app->session->hasFlash('error')) {
    echo "<div class='alert alert-success'>" . Yii::$app->session->getFlash('error') . "</div>";
}
?>
<div class='profile-form' style="padding:0px 10px;background-color: white">

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" style="text-align: left;font-size:16px;">
            Profile Detail
        </div>
        <div class="col-md-2"></div>
    </div>

   
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

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'first_name',
                            'middle_name',
                            'sur_name',
                            'father_name',
                            'date_of_birth',
                            'gender',
                            'sur_name',
                            'aadhaar_number',
                            'pan_number'
                        ],
                    ])
                    ?>
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'photo_profile',
                                'visible' => ($model->photo_profile != NULL),
                                'format' => 'raw',
                                'value' => $model->photo_profile != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->profle_model->getImageUrl("photo_profile") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
                                  </span>' : '',
                            ],
                        ],
                    ])
                    ?> 

                </div>
                <div class="col-md-6">



                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'photo_aadhaar_front',
                                'visible' => ($model->photo_aadhaar_front != NULL),
                                'format' => 'raw',
                                'value' => $model->photo_aadhaar_front != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->profle_model->getImageUrl("photo_aadhaar_front") . '" class="lozad" title="" style="cursor : pointer"/> 
                                  </span>' : '',
                            ],
                        ],
                    ])
                    ?> 



                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'photo_aadhaar_back',
                                'visible' => ($model->photo_aadhaar_back != NULL),
                                'format' => 'raw',
                                'value' => $model->photo_aadhaar_back != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->profle_model->getImageUrl("photo_aadhaar_back") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
                                  </span>' : '',
                            ],
                        ],
                    ])
                    ?> 

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'photo_pan',
                                'visible' => ($model->photo_pan != NULL),
                                'format' => 'raw',
                                'value' => $model->photo_pan != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->profle_model->getImageUrl("photo_pan") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
                                  </span>' : '',
                            ],
                        ],
                    ])
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
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'primary_phone_no',
                            'alternate_phone_no'
                        ],
                    ])
                    ?>

                </div>
                <div class="col-md-6">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'whatsapp_no',
                            'email_id'
                        ],
                    ])
                    ?>

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

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'present_address_house_no',
                            'present_address_street_mohalla',
                            'present_address_postoffice',
                            'present_address_district',
                            'present_address_state'
                        ],
                    ])
                    ?>
                </div>
                <div class="col-md-6">
                    <div class='title'>
                        <i class='icon-minus-sign'></i>
                        Permanent Address
                    </div>

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'permanent_address_house_no',
                            'permanent_address_street_mohalla',
                            'permanent_address_postoffice',
                            'permanent_address_district',
                            'permanent_address_state'
                        ],
                    ])
                    ?>

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

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'designation',
                            'date_of_joining',
                            'posting_district_name',
                            'posting_block_name',
                            'date_of_last_posting'
                        ],
                    ])
                    ?>

                </div>
                <div class="col-md-6">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'photo_letter_of_appointment',
                                'visible' => ($model->photo_letter_of_appointment != NULL),
                                'format' => 'raw',
                                'value' => $model->photo_letter_of_appointment != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->profle_model->getImageUrl("photo_letter_of_appointment") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
                                  </span>' : '',
                            ],
                        ],
                    ])
                    ?> 


                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'photo_service_agreement',
                                'visible' => ($model->photo_service_agreement != NULL),
                                'format' => 'raw',
                                'value' => $model->photo_service_agreement != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->profle_model->getImageUrl("photo_service_agreement") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
                                  </span>' : '',
                            ],
                        ],
                    ])
                    ?> 

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'photo_letter_of_last_posting_order',
                                'visible' => ($model->photo_letter_of_last_posting_order != NULL),
                                'format' => 'raw',
                                'value' => $model->photo_letter_of_last_posting_order != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->profle_model->getImageUrl("photo_letter_of_last_posting_order") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
                                  </span>' : '',
                            ],
                        ],
                    ])
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

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'bank_name',
                            'bank_branch',
                            'bank_account_number',
                            'bank_ifsc_code'
                        ],
                    ])
                    ?>
                </div>
                <div class="col-md-6">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'photo_pan',
                                'visible' => ($model->photo_bank_passbook != NULL),
                                'format' => 'raw',
                                'value' => $model->photo_bank_passbook != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->profle_model->getImageUrl("photo_bank_passbook") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
                                  </span>' : '',
                            ],
                        ],
                    ])
                    ?> 
                </div>
            </div>
        </div>
    </div>

    
</div>
<?php
$js = <<<JS
$(function () {
        $('.popb').elevateZoom({
         scrollZoom : true,
        responsive : true,
        zoomWindowOffetx:-600
   });
   $('.popbc').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
         .find('#imagecontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';     
        });
});  

JS;
$this->registerJs($js);
?>
<?php
$js = <<<JS
                
        observer = lozad('.lozad', {
                                        load: function (el) {
                                            console.log('loading element');
                                            el.src = el.getAttribute('data-src');
                                            // Custom implementation to load an element
                                            // e.g. el.src = el.getAttribute('data-src');

                
                
                                                $(el).elevateZoom({
                                                    scrollZoom: true,
                                                    responsive: true,
                                                    zoomWindowOffetx: -600
                                                });
                                                $('.popbc').click(function () {
                                                    $('#imagecontent').html('');
                                                    $('#modal').modal('show')
                                                            .find('#imagecontent')
                                                            .load($(this).attr('value'));
                                                    document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';
                                                });

//                                            $(function () {
//                                                $('.popb').elevateZoom({
//                                                    scrollZoom: true,
//                                                    responsive: true,
//                                                    zoomWindowOffetx: -600
//                                                });
//                                                $('.popbc').click(function () {
//                                                    $('#imagecontent').html('');
//                                                    $('#modal').modal('show')
//                                                            .find('#imagecontent')
//                                                            .load($(this).attr('value'));
//                                                    document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';
//                                                });
//                                            });

                                        }
                                    }); // lazy loads elements with default selector as '.lozad'
                                    observer.observe();     
        
JS;
$this->registerJs($js);
?> 

<style>
    .box .box-header.blue-background {
        color: #000;
    }
    .box .box-header {
        padding: 0px 15px;
    }
    .box .box-header {
        font-size: 21px;
        font-weight: 200;
        line-height: 30px;
        padding: 10px 15px;
        overflow: hidden;
        *zoom: 1;
        width: 100%;
    }
    .blue-background {
        background-color: #d9edf7 !important;
        border-color: #bce8f1;
    }
    th{
        font-weight: normal;
    }
    td{
        font-weight: normal;
    }
    hr{
        margin: 5px;
        height: 1px;
        background-color: #ccc;
        width: 106.8%;
    }

</style>
