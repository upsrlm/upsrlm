<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\shg\models\Shg */

$this->title = 'Bank Detail of '.$model->bc_application_model->name;
$this->params['breadcrumbs'][] = ['label' => 'Certified BC', 'url' => ['/training/participants/certified']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shg-create">
    <div class="panel panel-default">
        <div class='panel-body'>
            
            <?php $form = ActiveForm::begin(['id' => 'form-clf', 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
            
            <div class="row">
                <h3 class="header smaller lighter blue">Bank details/ बैंक का विवरण</h3>
                <div class="col-lg-4">
                    <?= $form->field($model, 'bank_account_no_of_the_bc')->label("Bank account no. of the BC/ BC का बैंक अकाउंट नंबर")->textInput() ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'bank_id')->label("Name Of Bank/ बैंक का नाम")->dropDownList($model->bank_option, ['prompt' => "Select Bank"]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'branch')->label("Branch/ बैंक शाखा का नाम")->textInput() ?>
                </div>
            </div>
            <div class="row">
                
                <div class="col-lg-4">
                    <?= $form->field($model, 'branch_code_or_ifsc')->label("Branch Code Or IFSC/ ब्रांच कोड/ या IFSC कोड")->textInput() ?>
                </div>
                 <div class="col-lg-4">
                  <?php
                    echo $form->field($model, 'date_of_opening_the_bank_account')->widget(DatePicker::classname(), [
                        'value' => $model->date_of_opening_the_bank_account,
                        'options' => ['placeholder' => 'Date of opening the bank account', 'class' => 'calculateday', 'readonly' => 'readonly'],
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
                    ])->label("Date Of Opening The Bank Account/ बैंक अकाउंट खोलने की तिथि");
                    ?>
                </div>
                 <div class="col-lg-4">
                    <?= $form->field($model, 'cin')->label("Customer Identification Number/ग्राहक पहचान संख्या ")->textInput() ?>
                </div>

                </div>
            <div class="row">
                                <div class="col-lg-4">
                    <?php
                    echo $form->field($model, 'passbook_photo')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions' => [
                            'showPreview' => false,
                            'showCaption' => true,
                            'showRemove' => false,
                            'showUpload' => false,
                            'initialPreview' => [
                            ],
                            'overwriteInitial' => true,
                        ],
                    ])->label('Passbook/Statement Photo');
                    ?>
                </div>
            </div>
            

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>     

