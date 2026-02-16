<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\widgets\DetailView;

$this->title = 'Add Samuh Sakhi detail';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                    <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button> -->
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => FALSE,
                                'enableAjaxValidation' => TRUE,
                                'layout' => 'default',
                                'options' => ['class' => 'form-horizontal', 'id' => 'approve-form', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>

                    <div class="row">           
                        <div class="col-lg-4">
                            <?php echo $form->field($model, 'samuh_sakhi_name'); ?> 

                        </div>
                        <div class="col-lg-4">
                            <?php echo $form->field($model, 'samuh_sakhi_age'); ?> 

                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo $form->field($model, 'samuh_sakhi_cbo_shg_id')->widget(kartik\select2\Select2::classname(), [
                                'data' => $model->shg_option,
                                'size' => Select2::MEDIUM,
                                'options' => ['placeholder' => 'जिस समूह की सदस्या हैं', 'multiple' => FALSE],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?> 

                        </div>

                    </div> 
                    <div class="row">           

                        <div class="col-lg-4">
                            <?php echo $form->field($model, 'samuh_sakhi_mobile_no'); ?> 
                        </div>
                        <div class="col-lg-4">
                            <?php echo $form->field($model, 'samuh_sakhi_mobile_type')->widget(kartik\select2\Select2::classname(), [
                                'data' => $model->mobile_type_option,
                                'size' => Select2::MEDIUM,
                                'options' => ['placeholder' => 'मोबाइल फ़ोन का प्रकार', 'multiple' => FALSE],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?> 

                        </div>
                        <div class="col-lg-4">

                            <?php echo $form->field($model, 'samuh_sakhi_social_category')->widget(kartik\select2\Select2::classname(), [
                                'data' => $model->cast_option,
                                'size' => Select2::MEDIUM,
                                'options' => ['placeholder' => 'सामाजिक श्रेणी', 'multiple' => FALSE],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?> 
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="col-lg-offset-5 col-lg-11">
                            <?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>
    </div>
</div>