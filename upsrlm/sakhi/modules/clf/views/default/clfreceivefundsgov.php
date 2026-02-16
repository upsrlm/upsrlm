<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <div class="panel-content">
                    <?php $form = ActiveForm::begin(['id' => 'form-clf-funds', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  

                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo $form->field($model, "fund_type")->label("किस थीमेटिक स्कीम के तहत ऋण/ फण्ड दी गयी")->dropDownList($model->fund_type_option, ['prompt' => "किस थीमेटिक स्कीम के तहत ऋण/ फण्ड दी गयी"]) ?> 

                        </div>

                        <div class="col-lg-6">
                            <?php
                            echo $form->field($model, "date_of_receipt")->widget(DatePicker::classname(), [
                                'value' => $model->date_of_receipt,
                                'options' => ['placeholder' => 'date of receipt', 'class' => 'calculateday', 'readonly' => 'readonly'],
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
                            ])->label('अद्यतन/ लेटेस्ट राशि प्राप्ति की तारीख');
                            ?>
                        </div>
                        <div class="col-lg-6">
                            <?php echo $form->field($model, "instalment_if_any")->textInput()->label('कोई इंस्टॉलमेंट हो तो संकेत करें') ?>
                        </div> 
                        <div class="col-lg-6">
                            <?php echo $form->field($model, "total_amount_received")->textInput()->label('कुल प्राप्त धनराशि') ?>
                        </div>
                        <div class="col-lg-6">
                            <?php echo $form->field($model, "balance_as_on_date")->textInput()->label('बैंक अकाउंट में दर्ज अद्यतन धनराशि') ?>
                        </div>
                    </div>    




                    <div class="form-group text-center">
                        <?= Html::submitButton('सेव', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>    

        </div>
    </div>
</div>

