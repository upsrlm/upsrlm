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
                    <?php $form = ActiveForm::begin(['id' => 'form-clf', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
                    <div class="row">

                        <div class="col-lg-6">
                            <?php echo $form->field($model, "name")->label('सदस्य का नाम')->textInput() ?>

                        </div>  
                        <div class="col-lg-6">      
                            <?php echo $form->field($model, "mobile_no")->label('मोबाइल नंबर')->textInput() ?>

                        </div>

                        <div class="col-lg-6">
                            <?php echo $form->field($model, "role")->dropDownList($model->member_role_option, ['prompt' => 'क्लस्टर स्तरीय संकुल में भूमिका चुने'])->label('क्लस्टर स्तरीय संकुल में भूमिका') ?>

                        </div>
                        <div class="col-lg-6">
                            <?php echo $form->field($model, "bank_operator")->dropDownList([0 => 'नहीं', '1' => 'हाँ'])->label('क्या बैंक अकाउंट संचालक हैं?') ?>

                        </div>
                        <div class="col-lg-6">
                            <?php echo $form->field($model, "cbo_vo_id")->dropDownList($model->cbo_vo_option, ['prompt' => 'Select VO']) ?>

                        </div>
                        <div class="col-lg-6">
                            <?php echo $form->field($model, "cbo_vo_off_bearer")->dropDownList([0 => 'No', '1' => 'Yes'], ['prompt' => 'Select']) ?>

                        </div>
                        <div class="col-lg-6">
                            <?php
                            echo $form->field($model, 'cbo_shg_id')->widget(DepDrop::classname(), [
                                'pluginOptions' => [
                                    'depends' => ['clfmemberform-cbo_vo_id'],
                                    'placeholder' => 'Select SHG',
                                    'url' => Url::to(['/clf/default/voshg'])
                                ]
                            ]);
                            ?>

                        </div>
                        <div class="col-lg-6">
                            <?php echo $form->field($model, "cbo_shg_off_bearer")->dropDownList([0 => 'No', '1' => 'Yes'], ['prompt' => 'Select']) ?>

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