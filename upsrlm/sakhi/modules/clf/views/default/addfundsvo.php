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
                    <?php $form = ActiveForm::begin(['id' => 'form-clf-vo-fund', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
                    <div class="row">
                        <div class="col-lg-6">      
                            <?= $form->field($model, 'name_of_vo')->textInput(['maxlength' => true, 'readonly' => 'readonly'])->label("ग्राम संगठन का नाम") ?>
                        </div>

                        <div class="col-lg-6">
                            <?php
                            echo $form->field($model, 'date_fund_loan_provision')->widget(DatePicker::classname(), [
                                'value' => $model->date_fund_loan_provision,
                                'options' => ['placeholder' => '', 'class' => 'calculateday', 'readonly' => 'readonly'],
//                        'removeButton' => FALSE,
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
                            ])->label("अगर उन्हें कोई फंड/ ऋण प्रदान की गई तो वह तिथि दर्ज करें");
                            ?>

                        </div>

                        <div class="col-lg-6">
                            <?= $form->field($model, 'fund_type')->label("किस थीमेटिक स्कीम के तहत ऋण/ फण्ड दी गयी")->dropDownList($model->fundstype_option, ['prompt' => "किस थीमेटिक स्कीम के तहत ऋण/ फण्ड दी गयी"]) ?>


                        </div>
                        <div class="col-lg-6">
                            <?= $form->field($model, 'loan_funds_amount')->textInput()->label("कितनी ऋण/ फण्ड दी गयी") ?>


                        </div>
                        <div class="col-lg-6">

                            <?= $form->field($model, 'refund_amount')->textInput()->label("वापसी राशि") ?>

                        </div>

                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('सेव', ['class' => 'btn btn-info btn-lg', 'name' => 'save_b', 'id' => 'save_b']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>    

        </div>
    </div>
</div>
