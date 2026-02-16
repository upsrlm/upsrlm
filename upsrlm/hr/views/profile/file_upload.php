<?php

use yii\helpers\Html;
use kartik\password\PasswordInput;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\widgets\TouchSpin;
use kartik\widgets\FileInput;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

$this->title = 'File Upload';
if (Yii::$app->session->hasFlash('error')) {
    echo "<div class='alert alert-success'>" . Yii::$app->session->getFlash('error') . "</div>";
}
?>
<div class='profile-form' style="padding:0px 10px;background-color: white">

    <?php
    $form = ActiveForm::begin([
                'id' => 'dynamic-form-file-upload',
                'enableClientValidation' => true,
                'enableAjaxValidation' => true,
                'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
                'fieldConfig' => [
                    'template' => "{label}<div class=\"col-lg-6\">{input}</div><div >{error}</div>",
                //'labelOptions' => ['class' => 'col-md-3 control-label'],
                ],
    ]);
    ?>
    <?php if ($status == 1) { ?>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8" style="text-align: left;font-size:16px;color:green">
                Photo uploaded successfully.
            </div>
            <div class="col-md-2"></div>
        </div>
        <script>
            setTimeout(function () {
                window.top.document.getElementById("profile-update-form").submit();
              //  window.top.location.href = "/profile/update";
            }, 1000);

        </script>
    <?php }
    ?>
    <div class='box bordered-box orange-border grey-background' style="padding:10px;margin:20px;background-color: #bbbbbb">       
        <div class='box-header box-main-header grey-background'>
            <div class='title1'>
                <i class='icon-minus-sign'></i>
                Note: Maximum upload size limit is 1 MB

            </div>
            <br/>
            <br/>
        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <?php
                    echo $form->field($model, 'file_type')->dropdownList($model->file_type_option, ['prompt' => 'Select File Type', 'readonly' => true]);
//                    echo $form->field($model, 'file_type')->widget(Select2::classname(), [
//                        'data' => $model->file_type_option,
//                        //'options' => ['placeholder' => 'Select File Type', 'style' => 'width:250px', 'readonly' => true],
////                        'pluginOptions' => [
////                            'allowClear' => false, //'readonly' => true,
////                        ],
////                        'readonly' => true,
//                    ]);
                    ?> 
                    <br/>
                    <?= $form->field($model, 'image_file')->fileInput(['accept' => 'image/*']) ?> 
                    <?php echo $form->field($model, 'user_id')->hiddenInput()->label(''); ?>
                </div>
                <div class="col-md-3">

                    <?php ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-5 col-lg-12">
            <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
