<?php

use yii\helpers\Html;
use kartik\password\PasswordInput;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
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

$this->title = "User registration for Banks to access details of BC Sakhis enrolled with UPSRLM, GOUP-empanelled partner banks";

if (Yii::$app->session->hasFlash('error')) {
    echo "<div class='alert alert-success'>" . Yii::$app->session->getFlash('error') . "</div>";
}
?>
<div class='profile-form' style="padding:0px 10px;background-color: white">

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
                Profile details
            </div>
        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'bank_name')->textInput(['readonly'=>'readonly']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'first_name') ?>  
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
                <div class="col-md-3">
                    <?= $form->field($model, 'primary_phone_no') ?>

                </div>
                <div class="col-md-3">

                    <?= $form->field($model, 'alternate_phone_no') ?>s
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'whatsapp_no') ?>

                </div>
                <div class="col-md-3">

                    <?= $form->field($model, 'email_id') ?>
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
                <div class="col-md-4">
                    <?= $form->field($model, 'place_of_posting') ?>

                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'designation') ?>

                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'employee_code_id') ?>

                </div>

            </div>
            <div class="row">
                <div class="col-md-4">
                    <?php
                    echo yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Please upload your photo id', ['id' => 'upload-photo-' . $model->bank_photoid1, 'class' => 'btn btn-sm btn-info btn-block popb', 'value' => '/profile/uploadfile?userid=' . $model->user_id . '&file_type=9', 'style' => 'width:300px', 'title' => 'upload your photo id']);
                    ?>
                    <?= $model->bank_photoid1 != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->profle_model->getImageUrl("bank_photoid1") . '" class="lozad" title="your photo id" style="cursor : pointer"/> 
                                  </span>' : '' ?>
                </div>  
                <div class="col-md-4">
                    <?php
                    echo yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Please upload your photo id', ['id' => 'upload-photo-' . $model->bank_photoid2, 'class' => 'btn btn-sm btn-info btn-block popb', 'value' => '/profile/uploadfile?userid=' . $model->user_id . '&file_type=10', 'style' => 'width:300px', 'title' => 'upload your photo id']);
                    ?> 
                    <?= $model->bank_photoid2 != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->profle_model->getImageUrl("bank_photoid2") . '" class="lozad" title="your photo id" style="cursor : pointer"/> 
                                  </span>' : '' ?>
                </div>
            </div>

        </div>
    </div>
    <div class='box bordered-box orange-border grey-background' style="padding:10px;margin:20px;background-color: #bbbbbb">       
        <div class='box-header box-main-header grey-background'>
            <div class='title'>
                <i class='icon-minus-sign'></i>
                Reporting Officer Information
            </div>
        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'bank_name_of_reporting_officer') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'bank_mobile_no_reporting_officer') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'bank_whatsapp_no_reporting_officer') ?>  
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'bank_email_reporting_officer') ?>   
                </div>
            </div>
        </div>
    </div>


    <div class='box bordered-box orange-border grey-background' style="padding:10px;margin:20px;background-color: #bbbbbb"> 
        <div class="row">
            <div class="col-lg-12">
                <p><strong>Declaration</strong>: Data accessed on this portal and all other content are property of UPSRLM, DoRD, Govt. of Uttar Pradesh. Use of the content and all connected digital services are aimed to aid perform programmatic and allied activities of UPSRLM and other State Departments. I on behalf of my organization declare to use these responsibly and without breaching standard practices. All statutory provisions apply. </p>
            </div>
        </div>
    </div>    

    <div class="form-group">
        <div class="col-md-3"></div>
        <div class="col-md-3">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="col-md-3">

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

$css = <<<cs
label {
  color: black !important;
}        
cs;
$this->registerCss($css);

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