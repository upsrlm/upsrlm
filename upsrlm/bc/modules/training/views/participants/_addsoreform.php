<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\widgets\DetailView;
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;

$this->title = 'Add Score';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= '' ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => FALSE,
                                'enableAjaxValidation' => TRUE,
                                'options' => ['id' => 'add-score-form', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            echo $form->field($model, 'training_status')->widget(Select2::classname(), [
                                'bsVersion' => '4.x',
                                'data' => $model->training_status_option,
                                'options' => ['placeholder' => 'Select Status', 'style' => 'width:250px'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <?php if ($model->tenth_not_pass) { ?>
                            <?=
                            $form->field($model, 'confirm_10th_pass', [
                                'template' => "<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                            ])->checkbox([
//                'checked' => false, 'required' => true,
                                'label' => "I've checked and Confirm  BC is 10th pass"
                            ])->label();
                            ?>
                        <?php } ?>
                        <div class="col-md-6">
                            <?= $form->field($model, 'exam_score')->textInput(['maxlength' => true]) ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'certificate_code')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-12">
                            <?php
                            echo $form->field($model, 'iibf_photo_file_name', ['enableClientValidation' => true])->widget(\kartik\widgets\FileInput::classname(), [
                                'bsVersion' => '4.x',
                                'options' => ['multiple' => false, 'accept' => 'image/*'],
                                'pluginOptions' => [
                                    'showPreview' => false,
                                    'showCaption' => true,
                                    'showCancel' => FALSE,
                                    'showRemove' => true,
                                    'showUpload' => false,
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-12 pt-3">
                        <div class="text-center">
                            <?= Html::submitButton('<i class="fal fa-save"></i> Save', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>      
<?php
$js = <<<JS
 $(function() {
    $('.field-addscoreform-exam_score').hide(); 
    $('.field-addscoreform-certificate_code').hide(); 
     $('.field-addscoreform-iibf_photo_file_name').hide();      
    if($('#addscoreform-training_status').val() == '34') {
      $('.field-addscoreform-exam_score').show();
      $('.field-addscoreform-certificate_code').show();
      $('.field-addscoreform-iibf_photo_file_name').show();    
     }   
    $('#addscoreform-training_status').change(function(){
        if($('#addscoreform-training_status').val() == '34') {
        $('.field-addscoreform-exam_score').show();
        $('.field-addscoreform-certificate_code').show();
        $('.field-addscoreform-iibf_photo_file_name').show();
        } else {
            $('.field-addscoreform-exam_score').hide(); 
            $('.field-addscoreform-certificate_code').hide(); 
            $('#addscoreform-exam_score').val(''); 
            $('#addscoreform-certificate_code').val(''); 
        } 
    });
});      
$('#add-score-form').on('beforeSubmit', function (e) {
    var form = $(this);
    var submit = form.find(':submit');
    submit.html('<span class="fa fa-spin fa-spinner"></span> Wait...');
    submit.prop('disabled', true);

});       
JS;
$this->registerJs($js);
?>
<?php
$css = <<<css
   div.required label.control-label:after {
    content: " *";
    color: red;
}
css;
$this->registerCss($css);
?>











