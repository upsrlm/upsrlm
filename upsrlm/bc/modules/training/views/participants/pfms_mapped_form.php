<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use kartik\checkbox\CheckboxX;

$this->title = 'BC SHG funds transfer';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => false,
                                'enableAjaxValidation' => true,
                                'options' => ['id' => 'bc-shg-maped-form', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>

                    <?php if ($model->shg_bank == 2) { ?>
                        <div class="row">
                            <!--                <div class="col-lg-12"><h3>BC SHG funds transfer</h3></div>-->
                            <div class="col-lg-6">
                                <?php //echo $form->field($model, 'pfms_maped_status')->radioList($model->option); ?> 
                                <?php echo $form->field($model, 'bc_shg_funds_status')->radioList($model->option); ?> 
                                <?php
                                echo $form->field($model, 'bc_shg_funds_date')->widget(DatePicker::classname(), [
                                    'value' => $model->bc_shg_funds_date,
                                    'options' => ['placeholder' => "", 'class' => 'calculateday', 'readonly' => 'readonly'],
                                    'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                                    'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                                    'pluginOptions' => [
                                        'readonly' => 'readonly',
                                        'format' => 'dd-mm-yyyy',
                                        'todayHighlight' => true,
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

                        </div>  
                    <?php } ?>
                    <div class="row" style="display: none">

                        <?php echo $form->field($model, 'shg_bank')->hiddenInput()->label(''); ?>
                    </div>    
                    <?php if ($model->shg_bank == 2) { ?>    
                        <div class="row">
                            <div class="col-lg-12">
                                <?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                            </div>
                        </div>
                    <?php } ?>   
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>