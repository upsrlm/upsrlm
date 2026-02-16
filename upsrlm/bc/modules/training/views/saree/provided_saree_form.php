<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$option11 = [];
$option12 = ['placeholder' => 'First Saree Provided date', 'class' => 'calculateday', 'readonly' => 'readonly'];

$option21 = [];
$option22 = ['placeholder' => 'First Saree Provided date', 'class' => 'calculateday', 'readonly' => 'readonly'];
if ($model->saree1_acknowledge=='1') {
    $option11 = ['disabled' => 'disabled'];
    $option12 = ['placeholder' => 'First Saree Provided date', 'class' => 'calculateday', 'readonly' => 'readonly','disabled' => 'disabled'];
}
if ($model->saree2_acknowledge=='1') {
    $option21 = ['disabled' => 'disabled'];
    $option22 = ['placeholder' => 'First Saree Provided date', 'class' => 'calculateday', 'readonly' => 'readonly','disabled' => 'disabled'];
}
?>

<div class="shg-form">
    <?php $form = ActiveForm::begin(['id' => 'form-bc-payment', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
    <div class="row">
        <table class="table">
            <tr>
                <th>Saree</th>
                <th>Provided Saree</th>

                <th>Provided Saree Date</th>
                <th>BC Response</th>
            </tr>   

            <tr>
                <td style="vertical-align:middle"><?= 'First Saree' ?></td>
                <td><?php echo $form->field($model, "saree1_provided")->dropDownList([0 => 'No', '1' => 'Yes'],$option11)->label('') ?></td>

                <td>
                    <?php
                    echo $form->field($model, "saree1_provided_date")->widget(DatePicker::classname(), [
                        'bsVersion' => '4.x',
                        'value' => $model->saree1_provided_date,
                        'options' => $option12,
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
                <td>
                 <?=(isset($model->saree1_acknowledge) and $model->saree1_acknowledge==1) ? 'Yes' : '<span class="color-danger-900">No</span>';?>   
                </td>

            </tr>
            <tr>
                <td style="vertical-align:middle"><?= 'Second Saree' ?></td>
                <td><?php echo $form->field($model, "saree2_provided")->dropDownList([0 => 'No', '1' => 'Yes'],$option21)->label('') ?></td>

                <td>
                    <?php
                    echo $form->field($model, "saree2_provided_date")->widget(DatePicker::classname(), [
                        'bsVersion' => '4.x',
                        'value' => $model->saree2_provided_date,
                        'options' => $option22,
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
                <td>
                <?=(isset($model->saree2_acknowledge) and $model->saree2_acknowledge==1) ? 'Yes' : '<span class="color-danger-900">No</span>';?>       
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
