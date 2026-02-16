<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
use common\models\master\MasterRole;

$this->title = 'Update Bank Detail of SHG : ' . $model->shg_model->name_of_shg;
$this->params['breadcrumbs'][] = ['label' => 'Certified BC', 'url' => ['/training/participants/certified']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shg-create">
    <div class="panel panel-default">
        <div class="panel-heading"><?= Html::encode($this->title) ?></div>
        <div class='panel-body'>
            

            <div class="shg-form">

                <?php $form = ActiveForm::begin(['id' => 'form-shg', 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'options' => ['enctype' => 'multipart/form-data']]); ?>  



                <div class="row">
                    <h3 class="header smaller lighter blue">Bank details/ बैंक का विवरण</h3>
                    <div class="col-lg-6">
                        <?= $form->field($model, 'bank_account_no_of_the_shg')->label("Bank account no. of the SHG/ SHG का बैंक अकाउंट नंबर")->textInput() ?>
                    </div>
                    <div class="col-lg-6">
                        <?= $form->field($model, 'bank_id')->label("Name Of Bank/ बैंक का नाम")->dropDownList($model->bank_option, ['prompt' => "Select Bank"]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <?= $form->field($model, 'branch')->label("Branch/ बैंक शाखा का नाम")->textInput() ?>
                    </div>
                    <div class="col-lg-6">
                        <?= $form->field($model, 'branch_code_or_ifsc')->label("Branch Code Or IFSC/ ब्रांच कोड/ या IFSC कोड")->textInput() ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <?php
                        echo $form->field($model, 'date_of_opening_the_bank_account')->widget(DatePicker::classname(), [
                            'value' => $model->date_of_opening_the_bank_account,
                            'options' => ['placeholder' => 'Date of opening the bank account', 'class' => 'calculateday', 'readonly' => 'readonly'],
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
                    <div class="col-lg-6">
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
                        ])->label('Passbook Photo)');
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>     
</div>
