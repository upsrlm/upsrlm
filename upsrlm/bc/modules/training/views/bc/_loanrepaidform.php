<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\web\JsExpression;

$this->title = 'Loan refund';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
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
                                'enableClientValidation' => TRUE,
                                'enableAjaxValidation' => false,
                                'options' => ['class' => 'form-horizontal', 'id' => 'upload-form', 'enctype' => 'multipart/form-data'],
                                'fieldConfig' => [
                                    'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
                                    'labelOptions' => ['class' => 'col-md-3 control-label'],
                                ],
                    ]);
                    ?>
                    <div class="col-md-12">
                        <?php
                        echo $form->field($model, 'bc_application_id')->widget(Select2::classname(), [
                            'data' => [],
                            'options' => ['multiple' => false, 'placeholder' => 'BC Sakhi'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 3,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                ],
                                'ajax' => [
                                    'url' => \yii\helpers\Url::to(['list']),
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($model, 'bc_return_amount')->textInput(['maxlength' => true]) ?>

                    </div>
                    <div class="col-md-12">
                        <?php
                        echo $form->field($model, "shg_confirm_funds_return_date")->widget(DatePicker::classname(), [
                            'value' => $model->shg_confirm_funds_return_date,
                            'options' => ['placeholder' => 'Return Amount Date', 'class' => 'calculateday', 'readonly' => 'readonly'],
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
                        ])->label('Return Amount Date');
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php
                        echo $form->field($model, 'shg_confirm_funds_return_photo')->widget(\kartik\widgets\FileInput::classname(), [
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
                    <div class="form-group">
                        <div class="col-lg-offset-5 col-lg-11">
                            <?= Html::submitButton('Upload', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div
    </div>
</div













