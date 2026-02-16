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

$this->title = "User Registration";
$this->params['breadcrumbs'][] = $this->title;
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
                Personal Information
            </div>
        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'first_name') ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'middle_name') ?>  
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'sur_name') ?>   
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
            <div class='title'>
                <i class='icon-minus-sign'></i>
                Official Information
            </div>

        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'designation') ?>

                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'office_address') ?>
                </div>
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
   