<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
?>
<h1>क्लस्टर स्तरीय संकुल के द्वारा प्राप्त धनराशिओं का विवरण</h1>
<div class="clf-form"><div class="rwow">
        <?php $form = ActiveForm::begin(['id' => 'form-clf-funds', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
        <?php
        if (isset($model->funds_model)) {
            $fno = 1;
            foreach ($model->funds_model as $i => $funds) {
                ?>
                <div class="panel">
                    <div class="col-lg-2">
                        <?php echo $form->field($funds, "[$i]fund_type")->hiddenInput(['value' => $funds->fund_type])->label('') ?>    
                        <?= $fno ?>. <?= $funds->type_name ?>
                    </div>
                    <div class="col-lg-1">
                        <?php echo $form->field($funds, "[$i]get_funds")->dropDownList([0 => 'नहीं', '1' => 'हाँ'])->label('धन प्राप्त हुआ') ?>
                    </div> 
                    <div class="col-lg-3">
                        <?php
                        echo $form->field($funds, "[$i]date_of_receipt")->widget(DatePicker::classname(), [
                            'value' => $funds->date_of_receipt,
                            'options' => ['placeholder' => 'date of receipt', 'class' => 'calculateday', 'readonly' => 'readonly'],
                            'removeButton' => FALSE,
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
                    <div class="col-lg-2">
                        <?php echo $form->field($funds, "[$i]instalment_if_any")->textInput()->label('कोई इंस्टॉलमेंट हो तो संकेत करें') ?>
                    </div> 
                    <div class="col-lg-2">
                        <?php echo $form->field($funds, "[$i]total_amount_received")->textInput()->label('कुल प्राप्त धनराशि') ?>
                    </div>
                    <div class="col-lg-2">
                        <?php echo $form->field($funds, "[$i]balance_as_on_date")->textInput()->label('बैंक अकाउंट में दर्ज अद्यतन धनराशि') ?>
                    </div>
                </div>    
                <?php
                $fno++;
            }
        }
        ?>

        <div class="form-group text-center">
            <?= Html::submitButton('सेव', ['class' => 'btn btn-lg btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
