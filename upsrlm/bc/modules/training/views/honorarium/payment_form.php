<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
?>

<div class="shg-form">
    <?php $form = ActiveForm::begin(['id' => 'form-bc-payment', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
    <div class="row">
        <table class="table">
            <tr>
                <th>Month</th>
                <th>Payment</th>
                <th>Month Name</th>

                <th>Payment Date</th></tr>   

            <tr>
                <td style="vertical-align:middle"><?= 'Month 1' ?></td>
                <td><?php echo $form->field($model, "month1_payment_get")->dropDownList([0 => 'No', '1' => 'Yes'])->label('') ?></td>
                <td>
                    <?php
                    echo $form->field($model, "month1")->widget(DatePicker::classname(), [
                        'bsVersion' => '4.x',
                        'options' => ['placeholder' => 'Month', 'value' => $model->month1 != null ? \Yii::$app->formatter->asDatetime($model->month1, "php:M-Y") : '',],
                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        'pluginOptions' => [
                            'autoclose' => true,
                            'startView' => 'year',
                            'minViewMode' => 'months',
                            'format' => 'M-yyyy'
                        ]
                    ])->label('');
                    ?>
                </td>
                <td>
                    <?php
                    echo $form->field($model, "month1_payment_date")->widget(DatePicker::classname(), [
                        'bsVersion' => '4.x',
                        'value' => $model->month1_payment_date,
                        'options' => ['placeholder' => 'Payment Date', 'class' => 'calculateday', 'readonly' => 'readonly'],
                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose' => true,
                            'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                        ],
                        'pluginEvents' => [
                            "changeDate" => "function(e) { "
                            . "}",
                        ]
                    ])->label('');
                    ?>  
                </td>

            </tr>
            <tr>
                <td style="vertical-align:middle"><?= 'Month 2' ?></td>
                <td><?php echo $form->field($model, "month2_payment_get")->dropDownList([0 => 'No', '1' => 'Yes'])->label('') ?></td>
                <td>
                    <?php
                    echo $form->field($model, "month2")->widget(DatePicker::classname(), [
                        'bsVersion' => '4.x',
                        'options' => ['placeholder' => 'Month', 'value' => $model->month2 != null ? \Yii::$app->formatter->asDatetime($model->month2, "php:M-Y") : '',],
                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        'pluginOptions' => [
                            'autoclose' => true,
                            'startView' => 'year',
                            'minViewMode' => 'months',
                            'format' => 'M-yyyy'
                        ]
                    ])->label('');
                    ?>
                </td>
                <td>
                    <?php
                    echo $form->field($model, "month2_payment_date")->widget(DatePicker::classname(), [
                        'bsVersion' => '4.x',
                        'value' => $model->month2_payment_date,
                        'options' => ['placeholder' => 'Payment Date', 'class' => 'calculateday', 'readonly' => 'readonly'],
                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose' => true,
                            'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                        ],
                        'pluginEvents' => [
                            "changeDate" => "function(e) { "
                            . "}",
                        ]
                    ])->label('');
                    ?>  
                </td>

            </tr>
            <tr>
                <td style="vertical-align:middle"><?= 'Month 3' ?></td>
                <td><?php echo $form->field($model, "month3_payment_get")->dropDownList([0 => 'No', '1' => 'Yes'])->label('') ?></td>
                <td>
                    <?php
                    echo $form->field($model, "month3")->widget(DatePicker::classname(), [
                        'bsVersion' => '4.x',
                        'options' => ['placeholder' => 'Month', 'value' => $model->month3 != null ? \Yii::$app->formatter->asDatetime($model->month3, "php:M-Y") : '',],
                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        'pluginOptions' => [
                            'autoclose' => true,
                            'startView' => 'year',
                            'minViewMode' => 'months',
                            'format' => 'M-yyyy'
                        ]
                    ])->label('');
                    ?>
                </td>
                <td>
                    <?php
                    echo $form->field($model, "month3_payment_date")->widget(DatePicker::classname(), [
                        'bsVersion' => '4.x',
                        'value' => $model->month3_payment_date,
                        'options' => ['placeholder' => 'Payment Date', 'class' => 'calculateday', 'readonly' => 'readonly'],
                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose' => true,
                            'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                        ],
                        'pluginEvents' => [
                            "changeDate" => "function(e) { "
                            . "}",
                        ]
                    ])->label('');
                    ?>  
                </td>

            </tr>
            <tr>
                <td style="vertical-align:middle"><?= 'Month 4' ?></td>
                <td><?php echo $form->field($model, "month4_payment_get")->dropDownList([0 => 'No', '1' => 'Yes'])->label('') ?></td>
                <td>
                    <?php
                    echo $form->field($model, "month4")->widget(DatePicker::classname(), [
                        'bsVersion' => '4.x',
                        'options' => ['placeholder' => 'Month', 'value' => $model->month4 != null ? \Yii::$app->formatter->asDatetime($model->month4, "php:M-Y") : '',],
                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        'pluginOptions' => [
                            'autoclose' => true,
                            'startView' => 'year',
                            'minViewMode' => 'months',
                            'format' => 'M-yyyy'
                        ]
                    ])->label('');
                    ?>
                </td>
                <td>
                    <?php
                    echo $form->field($model, "month4_payment_date")->widget(DatePicker::classname(), [
                        'bsVersion' => '4.x',
                        'value' => $model->month4_payment_date,
                        'options' => ['placeholder' => 'Payment Date', 'class' => 'calculateday', 'readonly' => 'readonly'],
                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose' => true,
                            'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                        ],
                        'pluginEvents' => [
                            "changeDate" => "function(e) { "
                            . "}",
                        ]
                    ])->label('');
                    ?>  
                </td>

            </tr>
            <tr>
                <td style="vertical-align:middle"><?= 'Month 5' ?></td>
                <td><?php echo $form->field($model, "month5_payment_get")->dropDownList([0 => 'No', '1' => 'Yes'])->label('') ?></td>
                <td>
                    <?php
                    echo $form->field($model, "month5")->widget(DatePicker::classname(), [
                        'bsVersion' => '4.x',
                        'options' => ['placeholder' => 'Month', 'value' => $model->month5 != null ? \Yii::$app->formatter->asDatetime($model->month5, "php:M-Y") : '',],
                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        'pluginOptions' => [
                            'autoclose' => true,
                            'startView' => 'year',
                            'minViewMode' => 'months',
                            'format' => 'M-yyyy'
                        ]
                    ])->label('');
                    ?>
                </td>
                <td>
                    <?php
                    echo $form->field($model, "month5_payment_date")->widget(DatePicker::classname(), [
                        'bsVersion' => '4.x',
                        'value' => $model->month5_payment_date,
                        'options' => ['placeholder' => 'Payment Date', 'class' => 'calculateday', 'readonly' => 'readonly'],
                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose' => true,
                            'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                        ],
                        'pluginEvents' => [
                            "changeDate" => "function(e) { "
                            . "}",
                        ]
                    ])->label('');
                    ?>  
                </td>

            </tr>
            <tr>
                <td style="vertical-align:middle"><?= 'Month 6' ?></td>
                <td><?php echo $form->field($model, "month6_payment_get")->dropDownList([0 => 'No', '1' => 'Yes'])->label('') ?></td>
                <td>
                    <?php
                    echo $form->field($model, "month6")->widget(DatePicker::classname(), [
                        'bsVersion' => '4.x',
                        'options' => ['placeholder' => 'Month', 'value' => $model->month6 != null ? \Yii::$app->formatter->asDatetime($model->month6, "php:M-Y") : '',],
                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        'pluginOptions' => [
                            'autoclose' => true,
                            'startView' => 'year',
                            'minViewMode' => 'months',
                            'format' => 'M-yyyy'
                        ]
                    ])->label('');
                    ?>
                </td>
                <td>
                    <?php
                    echo $form->field($model, "month6_payment_date")->widget(DatePicker::classname(), [
                        'bsVersion' => '4.x',
                        'value' => $model->month6_payment_date,
                        'options' => ['placeholder' => 'Payment Date', 'class' => 'calculateday', 'readonly' => 'readonly'],
                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'todayHighlight' => true,
                            'autoclose' => true,
                            'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                        ],
                        'pluginEvents' => [
                            "changeDate" => "function(e) { "
                            . "}",
                        ]
                    ])->label('');
                    ?>  
                </td>

            </tr>
        </table>
    </div>




    <div class="form-group text-center">
        <?php echo $form->field($model, "bc_application_id")->hiddenInput()->label('') ?>
        <?= Html::submitButton('save', ['class' => 'btn all btn-info', 'name' => 'submit_b', 'id' => 'submit_b']) ?>   


    </div>     
    <?php ActiveForm::end(); ?>
</div>
