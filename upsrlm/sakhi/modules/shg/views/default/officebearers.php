<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\date\DatePicker;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="panel-content">
                
                    <?php $form = ActiveForm::begin(['id' => 'form-shgmemberoffice', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo $form->field($model, "role")->dropDownList($model->shg_member_office_bearers_model->shgrolelist() ,['prompt' => 'चयन कीजिए'])->label('भूमिका') ?>
                        </div>  

                        <div class="col-lg-6">
                            <?php echo $form->field($model, "duration_of_membership")->dropDownList([1 => '12 महीने से कम', 2 => '13 से 30 महीने', 3=>'31-60 महीने'],['prompt' => 'चयन कीजिए'])->label('कितने समय से समूह के सदस्य हैं') ?>
                        </div>

                        <div class="col-lg-6">
                            <?php echo $form->field($model, "bank_account")->dropDownList([0 => 'नहीं', '1' => 'हाँ'],['prompt' => 'चयन कीजिए'])->label('क्या बैंक अकाउंट संचालक') ?>
                        </div>

                        <div class="col-lg-6">
                            <?php echo $form->field($model, "relative_in_shg")->dropDownList([0 => 'नहीं', '1' => 'हाँ'],['prompt' => 'चयन कीजिए'])->label('क्या समूह में परिवार/ रिश्तेदार') ?>
                        </div>

                        <div class="col-lg-6">
                            <?php echo $form->field($model, "no_of_relative")->label('अगर हाँ, तो कितने')->textInput() ?>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <?= Html::submitButton('सेव', ['class' => 'btn btn-lg btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>