<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\widgets\DetailView;

$this->title = 'Onboard';
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
                        <div class="col-lg-6">
                            <?= $form->field($model, 'onboarding')->radioList([1 => 'Yes', 0 => 'No']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            echo $form->field($model, "onboarding_date_time")->widget(DatePicker::classname(), [
                                'value' => $model->onboarding_date_time,
                                'options' => ['placeholder' => 'Onboard Date', 'class' => 'calculateday', 'readonly' => 'readonly'],
                                'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                                'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                                'pluginOptions' => [
                                    'readonly' => 'readonly',
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true,
                                    'autoclose' => true,
                                    'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                                ],
                                'pluginEvents' => [
                                    "changeDate" => "function(e) { "
                                    . "}",
                                ]
                            ])->label('Onboard Date');
                            ?>
                        </div>
                        <div class="col-lg-12">
                            <?= $form->field($model, 'bankidbc')->textInput(['maxlength' => 20]); ?>
                        </div> 
                        <div class="col-lg-12">
                            <?= $form->field($model, 'bc_email_id')->textInput(['maxlength' => 200]); ?>
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











