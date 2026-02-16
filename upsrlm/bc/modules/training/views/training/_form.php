<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;

;

use yii\widgets\DetailView;

$this->title = 'Add batch';
?>
<div class="add-batch_form">  

    <?php
    $form = ActiveForm::begin([
                'enableClientValidation' => FALSE,
                'enableAjaxValidation' => TRUE,
                'options' => ['id' => 'add-batch-form', 'enctype' => 'multipart/form-data'],
    ]);
    ?>

    <div class='panel-body'>
        <div class="row">
            <div class="col-md-6">
                District name : <?= $model->district_name ?> 
            </div> 
            <div class="col-md-3">
                <label><strong>Add Participant agree for training : <?= $model->no_of_participant ?></strong> </label>
            </div> 
            <div class="col-md-3">
                <label><strong>Total Training Participant : <?= isset($model->center_training_model) ? $model->center_training_model->no_of_participant : '0' ?></strong> </label>
            </div> 
        </div>      
    </div>   

    <div class="row">

        <div class="col-md-6">
            <?= $form->field($model, 'batch_name')->textInput(['maxlength' => true]) ?>

            <?php
            echo $form->field($model, 'schedule_date_of_exam')->widget(DatePicker::classname(), [
                
                'value' => $model->schedule_date_of_exam,
                'options' => ['placeholder' => 'Schedule date of exam', 'class' => 'calculateday', 'readonly' => 'readonly'],
                'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                'pluginOptions' => [
                    'orientation' => 'bottom',
                    'readonly' => 'readonly',
                    'format' => 'dd-mm-yyyy',
                    'todayHighlight' => true,
                    'endDate' => \Yii::$app->params['max_training_date'],
                    'autoclose' => true,
                    'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                ],
                'pluginEvents' => [
                    "changeDate" => "function(e) { "
                    . "}",
                ]
            ]);
            ?>
        </div>
        <div class="col-md-6">
            <?php
            echo $form->field($model, 'training_start_date')->widget(DatePicker::classname(), [
                'value' => $model->training_start_date,
                'options' => ['placeholder' => 'Training Start date', 'class' => 'calculateday', 'readonly' => 'readonly'],
                'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                'pluginOptions' => [
                    'orientation' => 'bottom',
                    'readonly' => 'readonly',
                    'format' => 'dd-mm-yyyy',
                    'todayHighlight' => true,
                    'endDate' => \Yii::$app->params['max_training_date'],
                    'autoclose' => true,
                    'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                ],
                'pluginEvents' => [
                    "changeDate" => "function(e) { "
                    . "}",
                ]
            ])->label("Training Start date");
            ?>
            <?php
            echo $form->field($model, 'training_end_date')->widget(DatePicker::classname(), [
                'value' => $model->training_end_date,
                'options' => ['placeholder' => 'Training End date', 'class' => 'calculateday', 'readonly' => 'readonly'],
                'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                'pluginOptions' => [
                    'orientation' => 'bottom',
                    'readonly' => 'readonly',
                    'format' => 'dd-mm-yyyy',
                    'todayHighlight' => true,
                    'endDate' => \Yii::$app->params['max_training_date'],
                    'autoclose' => true,
                    'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                ],
                'pluginEvents' => [
                    "changeDate" => "function(e) { "
                    . "}",
                ]
            ])->label("Training End date");
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
<?php
$js = <<<JS
       
$('#add-batch-form').on('beforeSubmit', function (e) {
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











