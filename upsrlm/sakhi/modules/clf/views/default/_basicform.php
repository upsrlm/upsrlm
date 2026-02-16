<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
?>

<div class="clf-form">
    <?php $form = ActiveForm::begin(['id' => 'form-clf', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
    <div class="row">

        <div class="col-lg-6">
            <?php
            echo $form->field($model, 'block_code')->widget(kartik\select2\Select2::classname(), [
                'data' => $model->block_option,
                'size' => Select2::MEDIUM,
                'options' => ['placeholder' => 'ब्लॉक का चयन करें', 'multiple' => FALSE],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label("ब्लॉक का चयन करें");
            ?>
        </div>  
        <div class="col-lg-6">      
            <?= $form->field($model, 'name_of_clf')->textInput(['maxlength' => true])->label("संकुल का नाम") ?>
        </div>

        <div class="col-lg-6">
            <?php
            echo $form->field($model, 'date_of_formation')->widget(DatePicker::classname(), [
                'value' => $model->date_of_formation,
                'options' => ['placeholder' => 'गठन की तिथि', 'class' => 'calculateday', 'readonly' => 'readonly'],
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
            ])->label("गठन की तिथि");
            ?>

        </div>

        <div class="col-lg-6">
            <?= $form->field($model, 'nrlm_clf_code')->textInput(['maxlength' => 30])->label("NRLM संकुल का कोड") ?>


        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'no_of_vo_connected')->textInput()->label("संकुल से कितने ग्राम संगठन संबद्ध हैं") ?>


        </div>
        <div class="col-lg-6">

            <?= $form->field($model, 'no_of_shg_connected')->textInput()->label("संकुल से कुल कितने SHG सम्बद्ध हैं") ?>

        </div>
        <div class="col-lg-6">

            <?= $form->field($model, 'no_of_gps_covered')->textInput()->label("संकुल कितने ग्राम पंचायत को आच्छादित करती हैं") ?>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12"><h3 class="header smaller lighter blue">बैंक का विवरण</h3></div>
        <div class="col-lg-6">
            <?= $form->field($model, 'bank_account_no_of_the_clf')->label("संकुल का बैंक अकाउंट नंबर")->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'bank_id')->label("बैंक का नाम")->dropDownList($model->bank_option, ['prompt' => "बैंक का नाम चयन करें"]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'branch')->label("बैंक शाखा का नाम")->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'branch_code_or_ifsc')->label("ब्रांच कोड/ या IFSC कोड")->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?php
            echo $form->field($model, 'date_of_opening_the_bank_account')->widget(DatePicker::classname(), [
                'value' => $model->date_of_opening_the_bank_account,
                'options' => ['placeholder' => 'बैंक अकाउंट खोलने की तिथि', 'class' => 'calculateday', 'readonly' => 'readonly'],
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
            ])->label("बैंक अकाउंट खोलने की तिथि");
            ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'updated_balance_in_bank')->label("Latest bank balance (should be updated in last 15 date)")->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?php
            echo $form->field($model, 'updated_balance_in_bank_date')->widget(DatePicker::classname(), [
                'value' => $model->updated_balance_in_bank_date,
                'options' => ['placeholder' => "नवीनतम बैंक बैलेंस तिथि (अंतिम 15 तारीख में अद्यतन की जानी चाहिए) )", 'class' => 'calculateday', 'readonly' => 'readonly'],
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
            ])->label("नवीनतम बैंक बैलेंस तिथि (अंतिम 15 तारीख में अद्यतन की जानी चाहिए) ");
            ?>
        </div>
        <div class="col-lg-12">
            <?php
            echo $form->field($model, 'passbook_photo')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'showPreview' => false,
                    'showCaption' => false,
                    'showRemove' => false,
                    'showCancel' => false,
                    'showUpload' => false,
                    'initialPreview' => [
                    ],
                    'overwriteInitial' => true,
                ],
            ])->label('Passbook Photo with date and balance (should be updated in last 15 date)');
            ?>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12"><h3 class="header smaller lighter blue">दुसरे बैंक का विवरण</h3></div>
        <div class="col-lg-6">
            <?= $form->field($model, 'bank_account_no_of_the_clf2')->label("दुसरे संकुल का बैंक अकाउंट नंबर")->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'bank_id2')->label("दुसरे बैंक का नाम")->dropDownList($model->bank_option, ['prompt' => "बैंक का नाम"]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'branch2')->label("दुसरे बैंक शाखा का नाम")->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'branch_code_or_ifsc2')->label("दुसरे बैंक अकाउंट का ब्रांच कोड/ या IFSC कोड")->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?php
            echo $form->field($model, 'date_of_opening_the_bank_account2')->widget(DatePicker::classname(), [
                'value' => $model->date_of_opening_the_bank_account2,
                'options' => ['placeholder' => 'दुसरे बैंक अकाउंट खोलने की तिथि', 'class' => 'calculateday', 'readonly' => 'readonly'],
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
            ])->label("दुसरे बैंक अकाउंट खोलने की तिथि");
            ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'updated_balance_in_bank2')->label("Latest bank balance of 2nd bank (should be updated in last 15 date)")->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?php
            echo $form->field($model, 'updated_balance_in_bank_date2')->widget(DatePicker::classname(), [
                'value' => $model->updated_balance_in_bank_date2,
                'options' => ['placeholder' => "Latest bank balance date of 2nd bank (should be updated in last 15 date)", 'class' => 'calculateday', 'readonly' => 'readonly'],
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
            ])->label("Latest bank balance date of 2nd bank (should be updated in last 15 date)");
            ?>
        </div>
        <div class="col-lg-12">
            <?php
            echo $form->field($model, 'passbook_photo2')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'showPreview' => false,
                    'showCaption' => false,
                    'showRemove' => false,
                    'showCancel' => false,
                    'showUpload' => false,
                    'initialPreview' => [
                    ],
                    'overwriteInitial' => true,
                ],
            ])->label('Passbook Photo with date and balance of 2nd bank (should be updated in last 15 date)');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12"><h3 class="header smaller lighter blue">तीसरा बैंक का विवरण</h3></div>
        <div class="col-lg-6">
            <?= $form->field($model, 'bank_account_no_of_the_clf3')->label("तीसरा संकुल का बैंक अकाउंट नंबर")->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'bank_id3')->label("तीसरा बैंक का नाम")->dropDownList($model->bank_option, ['prompt' => "Select Bank"]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'branch3')->label("तीसरा बैंक शाखा का नाम")->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'branch_code_or_ifsc3')->label("तीसरा बैंक अकाउंट का ब्रांच कोड/ या IFSC कोड")->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?php
            echo $form->field($model, 'date_of_opening_the_bank_account3')->widget(DatePicker::classname(), [
                'value' => $model->date_of_opening_the_bank_account3,
                'options' => ['placeholder' => 'तीसरा बैंक अकाउंट खोलने की तिथि', 'class' => 'calculateday', 'readonly' => 'readonly'],
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
            ])->label("तीसरा बैंक अकाउंट खोलने की तिथि");
            ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'updated_balance_in_bank3')->label("Latest bank balance of 3rd bank (should be updated in last 15 date)")->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?php
            echo $form->field($model, 'updated_balance_in_bank_date3')->widget(DatePicker::classname(), [
                'value' => $model->updated_balance_in_bank_date3,
                'options' => ['placeholder' => "Latest bank balance date of 3rd bank (should be updated in last 15 date)", 'class' => 'calculateday', 'readonly' => 'readonly'],
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
            ])->label("Latest bank balance date of 3rd bank (should be updated in last 15 date)");
            ?>
        </div>
        <div class="col-lg-12">
            <?php
            echo $form->field($model, 'passbook_photo3')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'showPreview' => false,
                    'showCaption' => false,
                    'showRemove' => false,
                    'showCancel' => false,
                    'showUpload' => false,
                    'initialPreview' => [
                    ],
                    'overwriteInitial' => true,
                ],
            ])->label('Passbook Photo with date and balance of 3rd bank (should be updated in last 15 date)');
            ?>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-6">
            <?= $form->field($model, 'is_registered_under')->radioList([1 => 'Yes', 0 => 'No'])->label('समाज के तहत पंजीकृत है'); ?>  
        </div>
        <div class="" id="yes" style="display: none">
            <div class="col-lg-6">
                <?= $form->field($model, 'reg_no')->label("पंजीकरण संख्या")->textInput() ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'pan_no')->label("पैन नंबर")->textInput() ?>
            </div>
            <div class="col-lg-12">
                <?php
                echo $form->field($model, 'pan_photo')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'showPreview' => false,
                        'showCaption' => false,
                        'showRemove' => false,
                        'showCancel' => false,
                        'showUpload' => false,
                        'initialPreview' => [
                        ],
                        'overwriteInitial' => true,
                    ],
                ])->label('पैन फोटो');
                ?>
            </div>
        </div>   
    </div>
    <div class="row">
        <div class="col-lg-12"> <h3 class="header smaller lighter blue">अकाउंटेंट विवरण</h3></div>
        <div class="col-lg-6">
            <?= $form->field($model, 'accountant_name')->label("अकाउंटेंट का नाम")->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'accountant_number')->label("अकाउंटेंट का मोबाइल नंबर")->textInput() ?>
        </div>
    </div>

    <div class="col-lg-12">
        <?php Html::submitButton('सेव', ['class' => 'btn btn-lg btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$js = <<<JS
    $(document).ready(function() {
        var is_registered_under = $('input[name="Clfbasicform[is_registered_under]"]:checked').val();
        if(is_registered_under == '1')
    {
        $('#yes').css("display","block");
    }
    else
    {
        $('#yes').css("display","none");
    }
       $('input[type="radio"]').click(function(){
        var is_registered_under = $('input[name="Clfbasicform[is_registered_under]"]:checked').val();
        if(is_registered_under == '1')
    {
        $('#yes').css("display","block");
    }
    else
    {
        $('#yes').css("display","none");
    }
    });
    
    });         
JS;
$this->registerJs($js);
?>