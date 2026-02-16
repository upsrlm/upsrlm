<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model bc\models\PartnerAssociates */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="partner-associates-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'profile-update-form',
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
                'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
                'fieldConfig' => [
//                    'template' => "<div class=\"col-lg-9\">{label}<br/>{input}<div>{error}</div></div>",
                //'labelOptions' => ['class' => 'col-md-3 control-label'],
                ],
    ]);
    ?>
    <div class="card">
        <div class="card-body">
            <div class="row">


                <div class="col-md-4">
                    <?= $form->field($model, 'name_of_the_field_officer')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'gender')->radioList(['1' => "Male", '2' => 'Female']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'age')->textInput(['placeholder' => 'Age', 'type' => 'number', 'min' => 12, 'max' => 70, 'step' => 1, 'pattern' => "[0-9]{10}"]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">


                <div class="col-md-4">
                    <?php
                    echo $form->field($model, 'photo_profile')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions' => [
                            'showPreview' => false,
                            'showCaption' => true,
                            'showRemove' => false,
                            'showCancel' => false,
                            'showUpload' => false,
                            'initialPreview' => [
                            ],
                            'overwriteInitial' => true,
                        ],
                    ])->label('Profile Photo');
                    ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'designation')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true]) ?>
                </div>

            </div>
        </div> 
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">


                <div class="col-md-4">
                    <?= $form->field($model, 'alternate_mobile_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'whatsapp_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'email_id')->textInput(['maxlength' => true]) ?>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">


                <div class="col-md-4">
                    <?php
                    echo $form->field($model, 'photo_aadhaar_front')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions' => [
                            'showPreview' => false,
                            'showCaption' => true,
                            'showRemove' => false,
                            'showCancel' => false,
                            'showUpload' => false,
                            'initialPreview' => [
                            ],
                            'overwriteInitial' => true,
                        ],
                    ])->label('Photo Aadhaar Front');
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                    echo $form->field($model, 'photo_aadhaar_back')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions' => [
                            'showPreview' => false,
                            'showCaption' => true,
                            'showRemove' => false,
                            'showCancel' => false,
                            'showUpload' => false,
                            'initialPreview' => [
                            ],
                            'overwriteInitial' => true,
                        ],
                    ])->label('Photo Aadhaar Back');
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                    echo $form->field($model, 'company_letter')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions' => [
                            'showPreview' => false,
                            'showCaption' => true,
                            'showRemove' => false,
                            'showCancel' => false,
                            'showUpload' => false,
                            'initialPreview' => [
                            ],
                            'overwriteInitial' => true,
                        ],
                    ])->label('Company letter/ testimony');
                    ?>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">


                <div class="col-md-4">
                    <?= $form->field($model, 'name_of_supervisor')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'designation_of_supervisor')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'mobile_no_of_supervisor')->textInput(['maxlength' => true]) ?>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">


                <div class="col-md-6">
                    <?php
                    echo $form->field($model, 'district_code')->widget(kartik\select2\Select2::classname(), [
                        'data' => $model->district_option,
                        'size' => Select2::MEDIUM,
                        'options' => ['placeholder' => 'Select District', 'multiple' => TRUE],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'block_code')->widget(DepDrop::classname(), [
                        'data' => $model->block_option,
                        'options' => ['placeholder' => 'Select  Block', 'multiple' => TRUE],
                        'pluginOptions' => [
                           
                            'depends' => ['partnerassociatesform-district_code'],
                            'url' => Url::to(['/ajax/getblock']),
                        ],
                    ]);
                    ?> 
                </div> 
            </div> 
        </div> 
    </div> 
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'bank_account_number')->textInput(['maxlength' => true])->label('Please mention company bank account no. where BCs make payment for handheld equipment') ?>

                </div> 
            </div> 
        </div> 
    </div> 
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
